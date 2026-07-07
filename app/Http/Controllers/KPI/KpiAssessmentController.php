<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\KpiIndicator;
use App\Models\KpiPeriod;
use App\Models\KpiScore;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KpiAssessmentController extends Controller
{

    public function index()
    {
        $query = DB::table('kpi_scores')
            ->join('employees', 'employees.id', '=', 'kpi_scores.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.department_id')
            ->join('periods', 'periods.id', '=', 'kpi_scores.period_id')
            ->selectRaw("
        employee_id,
        employees.name as employee_name,
        employees.employee_code,
        departments.name as department_name,
        period_id,
        periods.name as period_name,
        COUNT(*) as total_indicators,
        AVG(score) as average_score,
        SUM(final_score) as total_score,
        MAX(assessment_date) as assessment_date
    ")
            ->groupBy(
                'employee_id',
                'employees.name',
                'employees.employee_code',
                'period_id',
                'periods.name'
            );

        if ($search = request('search')) {

            $query->where(function ($q) use ($search) {
                $q->where('employees.name', 'like', "%{$search}%")
                    ->orWhere('employees.employee_code', 'like', "%{$search}%");
            });
        }
        if ($department = request('department')) {
            $query->where('employees.department_id', $department);
        }

        if ($period = request('period')) {
            $query->where('period_id', $period);
        }

        $assessments = $query
            ->orderByDesc('assessment_date')
            ->paginate(5)
            ->withQueryString();

        $currentPeriod = null;

        if (request('period')) {
            $currentPeriod = Period::find(request('period'));
        }


        $periods = Period::orderByDesc('start_date')->get();
        $departments = Department::orderBy('name')->get();
        return view('kpi.assessments.index', compact(
            'assessments',
            'periods',
            'currentPeriod',
            'departments'
        ));

        //     $assessments = KpiScore::query()
        //         ->join('employees', 'employees.id', '=', 'kpi_scores.employee_id')
        //         ->join('periods', 'periods.id', '=', 'kpi_scores.period_id')
        //         ->select(
        //             'employees.name as employee_name',
        //             'employee_id',
        //             'period_id',
        //             'periods.name as period_name',
        //             DB::raw('AVG(score) as average_score'),
        //             DB::raw('SUM(final_score) as total_score'),
        //             DB::raw('COUNT(*) as total_indicators'),
        //             DB::raw('MAX(assessment_date) as assessment_date')
        //         )
        //         ->groupBy(
        //             'employee_id',
        //             'period_id'
        //         )
        //         ->paginate(10);


    }

    public function show($employeeId, $periodId)
    {
        $scores = KpiScore::with([
            'employee.department',
            'indicator.master',
            'period',
            'assessor'
        ])
            ->where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->get();

        abort_if($scores->isEmpty(), 404);

        $employee = $scores->first()->employee;
        $period = $scores->first()->period;
        $assessor = $scores->first()->assessor;

        $averageScore = round($scores->avg('score'), 2);

        // $finalScore = round($scores->avg('final_score'), 2);
        $weightAvg   = round($scores->avg('final_score'), 2);
        // $finalScore = round(
        //     $scores
        //         ->groupBy('indicator.kpi_master_id')
        //         ->map(function ($items) {
        //             return $items->sum('final_score'); // atau sum(), sesuai perhitungan master
        //         }),
        //         //->avg(),
        //     2
        // );
        $finalScore = round(
            $scores->sum('final_score'),
            2
        );
        $groupedScores = $scores->groupBy(function ($item) {
            return $item->indicator->master->name ?? 'Other';
        });

        return view(
            'kpi.assessments.show',
            compact(
                'scores',
                'groupedScores',
                'employee',
                'period',
                'assessor',
                'averageScore',
                'finalScore',
                'weightAvg',
            )
        );
    }


    public function create()
    {
        $activePeriod = Period::where('status', 'active')->first();

        $employees = Employee::with(['department', 'leader'])
            ->whereDoesntHave('kpiScores', function ($query) use ($activePeriod) {
                $query->where('period_id', $activePeriod->id);
            })
            ->orderBy('name')
            ->get();

        $indicators = collect();

        if ($activePeriod) {
            $indicators = KpiIndicator::with('master')
                // ->whereHas('master', function ($q) use ($activePeriod) {
                //     $q->where('period_id', $activePeriod->id);
                // })
                ->orderBy('kpi_master_id')
                ->orderBy('id')
                ->orderBy('name')
                ->get();
        }

        return view('kpi.assessments.create', compact(
            'employees',
            'activePeriod',
            'indicators'
        ));
    }


    // public function create()
    // {
    //     return view('kpi.assessments.create', [
    //         'employees' => Employee::all(),
    //         'indicators' => KpiIndicator::all(),
    //         'periods' => Period::all(),
    //     ]);
    // }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'      => 'required|exists:employees,id',
            'period_id'        => 'required|exists:periods,id',
            'assessment_date'  => 'required|date',
            'assessor_id'      => 'required|exists:employees,id',

            'scores'           => 'required|array|min:1',
            'scores.*.score'   => 'required|numeric|min:0|max:100',
            'scores.*.notes'   => 'nullable|string|max:1000',
        ]);

        try {

            DB::beginTransaction();

            // Cek apakah employee sudah dinilai pada periode ini
            $exists = KpiScore::where('employee_id', $validated['employee_id'])
                ->where('period_id', $validated['period_id'])
                ->exists();

            if ($exists) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'This employee has already been assessed for the selected period.');
            }

            // Ambil semua weight indicator sekali saja
            $weights = KpiIndicator::whereIn('id', array_keys($validated['scores']))
                ->pluck('weight', 'id');

            foreach ($validated['scores'] as $indicatorId => $item) {

                $weight = $weights[$indicatorId] ?? 0;

                $finalScore = ($item['score'] * $weight) / 100;

                KpiScore::create([
                    'employee_id'     => $validated['employee_id'],
                    'period_id'       => $validated['period_id'],
                    'assessor_id'     => $validated['assessor_id'],
                    'indicator_id'    => $indicatorId,
                    'assessment_date' => $validated['assessment_date'],
                    'score'           => $item['score'],
                    'final_score'     => round($finalScore, 2),
                    'notes'           => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('kpi.assessments.index')
                ->with('success', 'KPI Assessment has been created successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Failed to save KPI Assessment. ' . $e->getMessage());
        }
    }

    public function edit($employeeId, $periodId)
    {
        $scores = KpiScore::with([
            'indicator',
            'employee.department',
            'period',
            'assessor'
        ])
            ->where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->get();

        abort_if($scores->isEmpty(), 404);

        $employee = $scores->first()->employee;
        $period = $scores->first()->period;
        $assessor = $scores->first()->assessor;

        //$finalScore = $scores->sum('final_score');

        $averageScore = round($scores->avg('score'), 2);


        $finalScore = round($scores->sum('final_score'), 2);


        // $finalScore = round(
        //     $scores
        //         ->groupBy('indicator.kpi_master_id')
        //         ->map(function ($items) {
        //             return $items->sum('final_score'); // atau sum(), sesuai perhitungan master
        //         })
        //         ->avg(),
        //     2
        // );

        return view('kpi.assessments.edit', compact(
            'scores',
            'employee',
            'period',
            'assessor',
            'finalScore',
            'averageScore'
        ));
    }


    public function update(Request $request, $employeeId, $periodId)
    {

        $scoreModels = KpiScore::with('indicator')
            ->whereIn('id', array_keys($request->scores))
            ->get()
            ->keyBy('id');

        foreach ($request->scores as $id => $item) {

            $score = $scoreModels[$id];

            $score->update([
                'score'           => $item['score'],
                'notes'           => $item['notes'] ?? null,
                'assessment_date' => $request->assessment_date,
                'final_score'     => ($item['score'] * $score->indicator->weight) / 100,
            ]);
        }

        return redirect()
            ->route('kpi.assessments.index')
            ->with('success', 'KPI Assessment updated successfully.');
    }


    // public function update(Request $request, KpiScore $kpiScore)
    // {
    //     $validated = $request->validate([
    //         'employee_id' => 'required',
    //         'indicator_id' => 'required',
    //         'score' => 'required|numeric|min:0|max:100',
    //         'final_score' => 'nullable|numeric',
    //         'assessment_date' => 'required|date',
    //         'notes' => 'nullable',
    //         'period_id' => 'required',
    //     ]);

    //     $kpiScore->update($validated);

    //     return redirect()
    //         ->route('kpi.assessments.index')
    //         ->with('success', 'Assessment updated successfully.');
    // }

    public function destroy(KpiScore $kpiScore)
    {
        $kpiScore->delete();

        return back()->with('success', 'Assessment deleted successfully.');
    }
}
