<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EmployeePerformanceResult;
use App\Models\KpiScore;
use App\Models\Period;
use App\Services\AI\GeminiAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KpiResultController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        abort_if(!$employee, 404, 'Employee not found.');

        $periods = Period::latest()->get();

        $results = [];

        foreach ($periods as $period) {

            $scores = KpiScore::where('employee_id', $employee->id)
                ->where('period_id', $period->id)
                ->get();

            if ($scores->isEmpty()) {
                continue;
            }

            $finalScore = round($scores->avg('final_score'), 2);

            $results[] = [
                'period' => $period,
                'total_kpi' => $scores->count(),
                'average_score' => round($scores->avg('score'), 2),
                'final_score' => $finalScore,
                'rating' => $this->rating($finalScore),
            ];
        }

        return view('employees.my-result.index', compact(
            'employee',
            'results'
        ));
    }

    public function show(Period $period)
    {
        $employee = auth()->user()->employee;
        abort_if(!$employee, 404, 'Employee not found.');

        $scores = KpiScore::with([
            'indicator.master',
            'indicator'
        ])
            ->where('employee_id', $employee->id)
            ->where('period_id', $period->id)
            ->get();

        $averageScore = round($scores->avg('score'), 2);

        $finalScore = round($scores->sum('final_score'), 2);

        $rating = $this->rating($finalScore);

        return view('employees.my-result.show', compact(
            'employee',
            'period',
            'scores',
            'averageScore',
            'finalScore',
            'rating'
        ));
    }

    private function rating($score)
    {
        return match (true) {
            $score >= 90 => 'Excellent',
            $score >= 80 => 'Very Good',
            $score >= 70 => 'Good',
            $score >= 60 => 'Fair',
            default => 'Poor',
        };
    }

    //

    public function resultIndex(Request $request)
    {


        abort_unless(
            auth()->user()->hasAnyRole(['super-admin', 'hrd']),
            403,
            'Unauthorized.'
        );



        $search       = trim($request->search);
        $departmentId = $request->department_id;
        $periodId     = $request->period_id;
        $status       = $request->status;

        $results = EmployeePerformanceResult::query()

            ->with([
                'employee.department',
                'employee.position',
                'period'
            ])

            ->when($search, function ($query) use ($search) {

                $query->whereHas('employee', function ($employee) use ($search) {

                    $employee->where(function ($q) use ($search) {

                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('employee_code', 'like', "%{$search}%");
                    });
                });
            })

            ->when($departmentId, function ($query) use ($departmentId) {

                $query->whereHas('employee', function ($employee) use ($departmentId) {

                    $employee->where('department_id', $departmentId);
                });
            })

            ->when($periodId, function ($query) use ($periodId) {

                $query->where('period_id', $periodId);
            })

            ->when($status, function ($query) use ($status) {

                $query->where('approval_status', $status);
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        $departments = Department::orderBy('name')->get();

        $periods = Period::orderByDesc('start_date')->get();


        return view('kpi-results.index', compact(
            'results',
            'departments',
            'periods'
        ));
    }


    public function resultShow(EmployeePerformanceResult $result)
    {

        abort_unless(
            auth()->user()->hasAnyRole(['hrd']),
            403,
            'Unauthorized.'
        );



        $result->load([
            'employee.department',
            'employee.position',
            'details.kpiMaster',
            'aiAnalysis',

        ]);

        return view('kpi-results.show', compact('result'));
    }



    public function generateAI(
        EmployeePerformanceResult $result,
        GeminiAnalysisService $gemini
    ) {
        try {
            $analysis = $gemini->analyze($result);

            return response()->json([
                'success' => true,
                'message' => 'AI Analysis berhasil dibuat.',
                'data' => $analysis
            ]);
        } catch (\Exception $e) {

            $message = 'AI service is currently unavailable.';

            if (str_contains($e->getMessage(), '429')) {
                $message = 'Gemini AI quota has been exceeded. Please try again later.';
            } elseif (str_contains($e->getMessage(), '401')) {
                $message = 'Invalid Gemini API Key.';
            } elseif (str_contains($e->getMessage(), '403')) {
                $message = 'Access to Gemini API was denied.';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);
        }
    }


    public function resultApprove(Request $request, EmployeePerformanceResult $result)
    {
        abort_unless(
            auth()->user()->hasAnyRole(['manager', 'hrd']),
            403,
            'Unauthorized.'
        );


        $result->update([

            'approval_status' => 'Approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_notes' => request('approval_notes')

        ]);

        return back()->with('success', 'KPI Result approved successfully.');
    }

    public function resultReject(Request $request, EmployeePerformanceResult $result)
    {

        abort_unless(
            auth()->user()->hasAnyRole(['manager', 'hrd']),
            403,
            'Unauthorized.'
        );


        request()->validate([
            'approval_notes' => 'required'
        ]);

        $result->update([

            'approval_status' => 'Rejected',

            'approved_by' => Auth::id(),

            'approved_at' => now(),

            'approval_notes' => request('approval_notes')

        ]);

        return back()->with('success', 'KPI Result rejected.');
    }
}
