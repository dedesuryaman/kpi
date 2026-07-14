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
        $data = $this->getData($request);

        return view('reports.abc.summary', $data);
    }

    /**
     * ABC Fitness Result
     */
    public function fitness(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.abc.fitness', $data);
    }

    /**
     * ABC Iteration History
     */
    public function iterations(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.abc.iterations', $data);
    }

    /**
     * Best Solution
     */
    public function bestSolution(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.abc.best-solution', $data);
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
                ->orderByDesc('fitness')
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
