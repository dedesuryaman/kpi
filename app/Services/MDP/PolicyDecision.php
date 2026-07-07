<?php

namespace App\Services\MDP;

use App\Models\MdpTransitionProbability;

class PolicyDecision
{
    public function decide(MdpTransitionProbability $transition): array
    {
        return [

            'action_id' => $transition->action_id,

            'action' => $transition->action->name,

            'recommendation' => match ($transition->action->code) {

                'PROMOTION' =>
                'Eligible for promotion.',

                'BONUS' =>
                'Eligible for performance bonus.',

                'COACHING' =>
                'Employee should attend coaching.',

                'WARNING' =>
                'Issue a warning letter and evaluate performance.',

                default =>
                'No recommendation.'
            }

        ];
    }
}
