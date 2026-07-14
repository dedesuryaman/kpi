<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Period;
use App\Models\RewardRecommendation;

class RewardReportController extends Controller
{
    /**
     * Reward Report
     */
    public function reward(Request $request)
    {
        $data = $this->getData($request);

        $data['results'] = $data['results']
            ->where('recommendation', 'Reward');

        return view('reports.reward.reward', $data);
    }

    /**
     * Punishment Report
     */
    public function punishment(Request $request)
    {
        $data = $this->getData($request);

        $data['results'] = $data['results']
            ->where('recommendation', 'Punishment');

        return view('reports.reward.punishment', $data);
    }

    /**
     * Approval Status Report
     */
    public function approval(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.reward.approval', $data);
    }

    /**
     * Statistics Report
     */
    public function statistics(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.reward.statistics', $data);
    }

    /**
     * Common Query
     */
    private function getData(Request $request): array
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = RewardRecommendation::with([
            'performanceResult.employee.department',
            'performanceResult.employee.position'
        ])
            ->whereHas('performanceResult', function ($q) use ($periodId) {
                $q->where('period_id', $periodId);
            });

        if ($departmentId) {
            $query->whereHas('performanceResult.employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $results = $query
            ->latest()
            ->get();

        return [

            'results' => $results,

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,

            'summary' => [

                'total' => $results->count(),

                'reward' => $results
                    ->where('recommendation', 'Reward')
                    ->count(),

                'punishment' => $results
                    ->where('recommendation', 'Punishment')
                    ->count(),

                'approved' => $results
                    ->where('status', 'Approved')
                    ->count(),

                'pending' => $results
                    ->where('status', 'Pending')
                    ->count(),

                'rejected' => $results
                    ->where('status', 'Rejected')
                    ->count(),

            ]

        ];
    }
}
