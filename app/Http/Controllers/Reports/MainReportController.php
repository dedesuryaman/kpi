<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Division;
use App\Models\Position;
use App\Models\KpiMaster;
use App\Models\Period;
use App\Models\EmployeePerformanceResult;
use App\Models\RewardRecommendation;
use App\Models\AbcResult;
use App\Models\MdpAnalysisResult;

class MainReportController extends Controller
{
    /**
     * Report Center
     */
    public function index()
    {
        $activePeriod = Period::where('status', 'active')->first();

        return view('reports.index', [

            // Master Data
            'employeeCount'    => Employee::count(),
            'departmentCount'  => Department::count(),
            'divisionCount'    => Division::count(),
            'positionCount'    => Position::count(),
            'kpiMasterCount'   => KpiMaster::count(),

            // Assessment
            'assessmentCount' => EmployeePerformanceResult::when(
                $activePeriod,
                fn($q) => $q->where('period_id', $activePeriod->id)
            )->count(),

            // ABC
            'abcCount' => AbcResult::count(),

            // MDP
            'mdpCount' => MdpAnalysisResult::count(),

            // Reward
            'rewardCount' => RewardRecommendation::count(),

            // Active Period
            'activePeriod' => $activePeriod,
        ]);
    }
}
