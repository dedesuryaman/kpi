<?php

namespace App\Services\MDP;

use App\Models\MdpTransitionProbability;

class TransitionResolver
{
    public function resolve(int $stateId)
    {
        return MdpTransitionProbability::with([
            'action',
            'toState'
        ])
            ->where('from_state_id', $stateId)
            ->orderByDesc('probability')
            ->first();
    }
}
