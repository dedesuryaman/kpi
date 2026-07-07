<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdpTransition extends Model
{
    protected $fillable = [
        'from_state',
        'to_state',
        'probability',
        'period_id',
    ];

    protected $casts = [
        'probability' => 'decimal:4',
    ];

    public function fromState()
    {
        return $this->belongsTo(
            MdpState::class,
            'from_state'
        );
    }

    public function toState()
    {
        return $this->belongsTo(
            MdpState::class,
            'to_state'
        );
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
