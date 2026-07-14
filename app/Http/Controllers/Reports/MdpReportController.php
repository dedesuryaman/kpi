<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MdpAnalysisResult;
use App\Models\Department;
use App\Models\MdpAction;
use App\Models\MdpState;
use App\Models\MdpTransitionProbability;
use App\Models\Period;

class MdpReportController extends Controller
{
    /**
     * MDP Decision Summary
     */

    public function summary(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');


        $states = MdpState::where('period_id', $periodId)
            ->count();


        $actions = MdpAction::where('period_id', $periodId)
            ->count();


        $transitions = MdpTransitionProbability::whereHas(
            'state',
            function ($q) use ($periodId) {
                $q->where('period_id', $periodId);
            }
        )->count();


        $analysis = MdpAnalysisResult::with([
            'employee'
        ])
            ->where('period_id', $periodId)
            ->latest()
            ->get();


        $summary = [

            'states' => $states,

            'actions' => $actions,

            'transitions' => $transitions,

            'employees' => $analysis->count(),

            'average_reward' => round(
                $analysis->avg('reward') ?? 0,
                2
            ),

        ];


        return view('reports.mdp.summary', [

            'summary' => $summary,

            'results' => $analysis,

            'periods' => Period::latest()->get(),

            'selectedPeriod' => $periodId,

        ]);
    }

    /**
     * Employee State Analysis
     */
    public function states(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.mdp.states', $data);
    }

    /**
     * Action Recommendation
     */
    public function actions(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.mdp.actions', $data);
    }

    /**
     * Reward Analysis
     */
    public function rewards(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.mdp.rewards', $data);
    }

    /**
     * Transition Probability
     */
    public function transitions(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.mdp.transitions', $data);
    }

    /**
     * Common Query
     */
    private function getData(Request $request): array
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = MdpAnalysisResult::with([
            'employee.department',
            'employee.position'
        ])
            ->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        return [

            'results' => $query
                ->orderByDesc('expected_reward')
                ->paginate(20),

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,

            'summary' => [
                'totalEmployee' => (clone $query)->count(),
                'averageReward' => (clone $query)->avg('expected_reward'),
                'maxReward'     => (clone $query)->max('expected_reward'),
                'minReward'     => (clone $query)->min('expected_reward'),
            ]

        ];
    }
}
