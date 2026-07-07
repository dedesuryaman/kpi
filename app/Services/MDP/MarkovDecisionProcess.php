<?php

namespace App\Services\MDP;

use App\Models\AbcResult;
use App\Models\EmployeePerformanceResult;
use App\Models\MdpAnalysisResult;

class MarkovDecisionProcess
{
    public function run(int $periodId): void
    {
        $abc = AbcResult::where('period_id', $periodId)
            ->where('is_best', true)
            ->firstOrFail();

        $performances = EmployeePerformanceResult::where(
            'period_id',
            $periodId
        )->get();

        $stateBuilder = new StateBuilder();

        $transitionResolver = new TransitionResolver();

        $rewardCalculator = new RewardCalculator();

        $policyDecision = new PolicyDecision();

        foreach ($performances as $performance) {

            $state = $stateBuilder
                ->resolve($performance->final_score);

            $transition = $transitionResolver
                ->resolve($state->id);

            $reward = $rewardCalculator
                ->calculate($transition);

            $policy = $policyDecision
                ->decide($transition);

            MdpAnalysisResult::updateOrCreate(

                [

                    'period_id' => $periodId,
                    'employee_id' => $performance->employee_id,

                ],

                [

                    'abc_result_id' => $abc->id,

                    'employee_performance_result_id' => $performance->id,

                    'state_id' => $state->id,

                    'action_id' => $policy['action_id'],

                    'reward' => $reward,

                    'discount_factor' => 0.90,

                    'recommendation' => $policy['recommendation']

                ]

            );
        }
    }
}
