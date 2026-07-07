<?php

namespace App\Services\MDP;

use App\Models\MdpTransitionProbability;

class RewardCalculator
{
    public function calculate(MdpTransitionProbability $transition): float
    {
        return (float)$transition->reward;
    }
}
