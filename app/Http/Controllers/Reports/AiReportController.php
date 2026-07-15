<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\EmployeePerformanceResult;
use App\Models\Period;

class AiReportController extends Controller
{
    /**
     * AI Summary Report
     */
    public function summary(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.ai.summary', $data);
    }

    /**
     * Individual AI Analysis
     */
    public function individual(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.ai.individual', $data);
    }

    /**
     * Department AI Analysis
     */
    public function department(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.ai.department', $data);
    }

    /**
     * AI Recommendation Report
     */
    public function recommendations(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.ai.recommendations', $data);
    }

    /**
     * Common Query
     */
    private function getData(Request $request): array
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position',
            'latestAiAnalysis'
        ])
            ->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $results = $query
            ->orderByDesc('final_score')
            ->paginate(20);

        $departmentSummary = (clone $query)
            ->get()
            ->groupBy(fn($item) => $item->employee->department->name ?? 'No Department')
            ->map(function ($items) {
                return [
                    'employees' => $items->count(),
                    'average_score' => round($items->avg('final_score'), 2),
                    'analyzed' => $items->whereNotNull('latestAiAnalysis')->count(),
                ];
            });

        return [

            'results' => $results,

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,

            'departmentSummary' => $departmentSummary,

            // 'summary' => [

            //     'totalEmployee' => $results->total(),

            //     'analyzed' => $results->getCollection()
            //         ->filter(fn($item) => $item->latestAiAnalysis)
            //         ->count(),

            //     'notAnalyzed' => $results->getCollection()
            //         ->filter(fn($item) => !$item->latestAiAnalysis)
            //         ->count(),

            // ]
            'summary' => [
                'totalEmployee' => (clone $query)->count(),

                'analyzed' => (clone $query)
                    ->whereHas('latestAiAnalysis')
                    ->count(),

                'notAnalyzed' => (clone $query)
                    ->whereDoesntHave('latestAiAnalysis')
                    ->count(),
            ]

        ];
    }
}
