<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdpReward extends Model
{
    protected $fillable = [
        'state_id',
        'action_id',
        'reward_value',
        'cost',
        'utility',
    ];

    protected $casts = [
        'reward_value' => 'decimal:2',
        'cost' => 'decimal:2',
        'utility' => 'decimal:4',
    ];

    public function state()
    {
        return $this->belongsTo(MdpState::class);
    }

    public function action()
    {
        return $this->belongsTo(MdpAction::class);
    }
}
