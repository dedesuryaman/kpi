<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdpPolicy extends Model
{
    protected $fillable = [
        'employee_id',
        'best_action',
        'expected_reward',
        'recommendation',
        'period_id',
    ];

    protected $casts = [
        'expected_reward' => 'decimal:4',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function action()
    {
        return $this->belongsTo(
            MdpAction::class,
            'best_action'
        );
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
