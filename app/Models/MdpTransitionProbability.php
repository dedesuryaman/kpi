<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MdpTransitionProbability extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_state_id',
        'to_state_id',
        'action_id',
        'probability',
        'reward'
    ];

    public function fromState()
    {
        return $this->belongsTo(MdpState::class, 'from_state_id');
    }

    public function toState()
    {
        return $this->belongsTo(MdpState::class, 'to_state_id');
    }

    public function state()
    {
        return $this->belongsTo(MdpState::class, 'to_state_id');
    }


    public function action()
    {
        return $this->belongsTo(MdpAction::class);
    }
}
