<?php

namespace App\Http\Controllers\Reports;

use App\Exports\PerformanceSummaryReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePerformanceResult;
use App\Models\Department;
use App\Models\Period;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class PerformanceReportController extends Controller
{
    /**
     * Performance Summary
     */
    public function summary(Request $request)
    {
        return view(
            'reports.performance.summary',
            $this->getPerformanceData($request)
        );
    }

    public function summaryExcel(Request $request)
    {
        return Excel::download(
            new PerformanceSummaryReportExport($request),
            'performance_summary.xlsx'
        );
    }
    
    public function summaryPdf(Request $request)
    {
        $data = $this->getPerformanceData($request, false);

        $period = Period::find($data['selectedPeriod']);

        $pdf = Pdf::loadView(
            'reports.performance.pdf.summary',
            [
                'results' => $data['results'],
                'summary' => $data['summary'],
                'period' => $period
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->stream('performance_summary.pdf');
    }

    /**
     * Performance Detail
     */
    public function detail(Request $request)
    {
        $data = $this->getPerformanceData($request);

        return view('reports.performance.detail', $data);
    }

    /**
     * Employee Ranking
     */
    public function ranking(Request $request)
    {
        return view(
            'reports.performance.ranking',
            $this->getPerformanceData($request)
        );
    }

    /**
     * Top Performance
     */
    public function top(Request $request)
    {
        $data = $this->getPerformanceData($request);

        $data['results'] = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position',
            'latestRewardRecommendation'
        ])
            ->where('period_id', $data['selectedPeriod'])
            ->when($data['selectedDepartment'], function ($q) use ($data) {
                $q->whereHas('employee', function ($emp) use ($data) {
                    $emp->where('department_id', $data['selectedDepartment']);
                });
            })
            ->orderByDesc('final_score')
            ->limit(10)
            ->get();

        return view('reports.performance.top', $data);
    }
    /**
     * Lowest Performance
     */
    public function lowest(Request $request)
    {
        $data = $this->getPerformanceData($request);

        $query = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position',
            'latestRewardRecommendation'
        ])->where('period_id', $data['selectedPeriod']);

        if ($data['selectedDepartment']) {
            $query->whereHas('employee', function ($q) use ($data) {
                $q->where('department_id', $data['selectedDepartment']);
            });
        }

        $data['results'] = $query
            ->orderBy('final_score')
            ->limit(10)
            ->get();

        return view('reports.performance.lowest', $data);
    }

    /**
     * Department Performance
     */
    public function department(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departments = Department::leftJoin(
            'employees',
            'departments.id',
            '=',
            'employees.department_id'
        )
            ->leftJoin('employee_performance_results', function ($join) use ($periodId) {

                $join->on(
                    'employees.id',
                    '=',
                    'employee_performance_results.employee_id'
                );

                $join->where(
                    'employee_performance_results.period_id',
                    $periodId
                );
            })
            ->select(
                'departments.id',
                'departments.name'
            )
            ->selectRaw('COUNT(DISTINCT employees.id) as employees_count')
            ->selectRaw('AVG(employee_performance_results.final_score) as average_score')
            ->selectRaw('MAX(employee_performance_results.final_score) as highest_score')
            ->selectRaw('MIN(employee_performance_results.final_score) as lowest_score')
            ->groupBy(
                'departments.id',
                'departments.name'
            )
            ->orderBy('departments.name')
            ->get();

        return view('reports.performance.department', [

            'departments' => $departments,

            'periods' => Period::latest()->get(),

            'selectedPeriod' => $periodId,

        ]);
    }

    /**
     * Common Query
     */
    private function getPerformanceData(Request $request, bool $paginate = true): array
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position',
            'abcResult',
            'mdpResult',
            'latestAiAnalysis',
            'latestRewardRecommendation'
        ])->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $summaryQuery = clone $query;

        $summary = [
            'employees' => $summaryQuery->count(),
            'average'   => round((clone $query)->avg('final_score') ?? 0, 2),
            'highest'   => round((clone $query)->max('final_score') ?? 0, 2),
            'lowest'    => round((clone $query)->min('final_score') ?? 0, 2),
        ];

        $results = $paginate
            ? $query->orderByDesc('final_score')->paginate(20)->withQueryString()
            : $query->orderByDesc('final_score')->get();

        return [
            'results' => $results,
            'summary' => $summary,
            'periods' => Period::latest()->get(),
            'departments' => Department::orderBy('name')->get(),
            'selectedPeriod' => $periodId,
            'selectedDepartment' => $departmentId,
        ];
    }
}
