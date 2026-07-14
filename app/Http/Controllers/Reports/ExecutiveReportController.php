<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePerformanceResult;
use App\Models\RewardRecommendation;

class ExecutiveReportController extends Controller
{
    /**
     * Executive Dashboard Report
     */
    public function dashboard(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.executive.dashboard', $data);
    }

    /**
     * Company KPI Report
     */
    public function companyKpi(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.executive.company-kpi', $data);
    }

    /**
     * Performance Summary
     */
    public function performanceSummary(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.executive.performance-summary', $data);
    }

    /**
     * Strategic KPI Report
     */
    public function strategicKpi(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.executive.strategic-kpi', $data);
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
            'latestRewardRecommendation'
        ])
            ->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $results = $query->get();

        return [

            'results' => $results,

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,

            'summary' => [

                'employeeCount' => Employee::count(),

                'departmentCount' => Department::count(),

                'averageScore' => round($results->avg('final_score'), 2),

                'highestScore' => round($results->max('final_score'), 2),

                'lowestScore' => round($results->min('final_score'), 2),

                'rewardCount' => RewardRecommendation::whereHas(
                    'performanceResult',
                    fn($q) => $q->where('period_id', $periodId)
                )->where('recommendation', 'Reward')->count(),

                'punishmentCount' => RewardRecommendation::whereHas(
                    'performanceResult',
                    fn($q) => $q->where('period_id', $periodId)
                )->where('recommendation', 'Punishment')->count(),

            ],

        ];
    }
}
