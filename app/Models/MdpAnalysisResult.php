<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdpAnalysisResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'employee_id',
        'abc_result_id',
        'employee_performance_result_id',
        'state_id',
        'action_id',
        'reward',
        'discount_factor',
        'recommendation'
    ];

    protected $casts = [
        'reward' => 'float',
        'discount_factor' => 'float'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function abcResult()
    {
        return $this->belongsTo(AbcResult::class);
    }

    public function performance()
    {
        return $this->belongsTo(EmployeePerformanceResult::class, 'employee_performance_result_id');
    }

    public function state()
    {
        return $this->belongsTo(MdpState::class);
    }

    public function action()
    {
        return $this->belongsTo(MdpAction::class);
    }
}
