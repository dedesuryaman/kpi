<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbcResult;
use App\Models\AbcResultDetail;
use App\Models\Department;
use App\Models\Period;

class AbcReportController extends Controller
{
    /**
     * ABC Optimization Summary
     */
    public function summary(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $abc = AbcResult::with([
            'period',
            'details.kpiMaster'
        ])
            ->where('period_id', $periodId)
            ->latest()
            ->first();

        return view('reports.abc.summary', [

            'abc' => $abc,

            'periods' => Period::latest()->get(),

            'selectedPeriod' => $periodId,

        ]);
    }

    /**
     * ABC Fitness Result
     */

    public function fitness(Request $request)
    {
        $results = AbcResult::with('period')
            ->latest()
            ->paginate(20);

        return view('reports.abc.fitness', [

            'results' => $results,

        ]);
    }

    /**
     * ABC Iteration History
     */
    public function iterations(Request $request)
    {
        $results = AbcResult::with('period')
            ->latest()
            ->paginate(20);

        return view('reports.abc.iterations', compact('results'));
    }
    /**
     * Best Solution
     */

    public function bestSolution(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $abc = AbcResult::with([
            'period',
            'details.kpiMaster'
        ])
            ->where('period_id', $periodId)
            ->where('is_best', true)
            ->latest()
            ->first();

        return view('reports.abc.best-solution', [

            'abc' => $abc,

            'periods' => Period::latest()->get(),

            'selectedPeriod' => $periodId,

        ]);
    }

    /**
     * Common Data
     */
    private function getData(Request $request): array
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = AbcResultDetail::with([
            'employee.department',
            'employee.position',
            'abcResult'
        ])
            ->whereHas('abcResult', function ($q) use ($periodId) {
                $q->where('period_id', $periodId);
            });

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        return [

            'results' => $query
                // ->orderByDesc('abc_result_id')
                ->paginate(20),

            'abcResult' => AbcResult::where('period_id', $periodId)
                ->latest()
                ->first(),

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,

        ];
    }
}
