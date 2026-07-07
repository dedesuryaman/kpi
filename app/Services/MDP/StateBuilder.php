<?php

namespace App\Services\MDP;

use App\Models\MdpState;

class StateBuilder
{
    public function resolve(float $score): MdpState
    {
        return MdpState::where('status', true)
            ->where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->firstOrFail();
    }
}
