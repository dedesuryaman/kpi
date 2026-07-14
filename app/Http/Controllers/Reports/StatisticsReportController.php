<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\EmployeePerformanceResult;
use App\Models\Period;
use Illuminate\Support\Facades\DB;

class StatisticsReportController extends Controller
{
    /**
     * Attendance Statistics
     */
    public function attendance(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.attendance', $data);
    }

    /**
     * Productivity Statistics
     */
    public function productivity(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.productivity', $data);
    }

    /**
     * Quality Statistics
     */
    public function quality(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.quality', $data);
    }

    /**
     * Discipline Statistics
     */
    public function discipline(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.discipline', $data);
    }

    /**
     * Innovation Statistics
     */
    public function innovation(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.innovation', $data);
    }

    /**
     * Department Comparison
     */
    public function departmentComparison(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.department-comparison', $data);
    }

    /**
     * Period Comparison
     */
    public function periodComparison(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.statistics.period-comparison', $data);
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
            'employee.department'
        ])
            ->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $results = $query->get();

        $departmentStats = EmployeePerformanceResult::select(
            'departments.name',
            DB::raw('AVG(final_score) as average_score'),
            DB::raw('COUNT(*) as total_employee')
        )
            ->join('employees', 'employee_performance_results.employee_id', '=', 'employees.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->where('employee_performance_results.period_id', $periodId)
            ->groupBy('departments.name')
            ->orderBy('departments.name')
            ->get();

        return [

            'results' => $results,

            'departmentStats' => $departmentStats,

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,

            'summary' => [

                'employeeCount' => $results->count(),

                'averageScore' => round($results->avg('final_score'), 2),

                'highestScore' => round($results->max('final_score'), 2),

                'lowestScore' => round($results->min('final_score'), 2),

            ],

        ];
    }
}
