<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePerformanceResult extends Model
{
    protected $fillable = [

        'period_id',

        'employee_id',

        'average_score',

        'final_score',

        'grade',

        'rank',

        'approval_status',

        'approved_by',

        'approved_at',

        'approval_notes',

    ];

    public function abcResult()
    {
        return $this->hasOne(AbcResult::class, 'id', 'period_id');
    }

    public function mdpResult()
    {
        return $this->hasOne(MdpAnalysisResult::class, 'employee_performance_result_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function details()
    {
        return $this->hasMany(
            EmployeePerformanceDetail::class,
            'performance_result_id'
        );
    }

    public function rewardRecommendations()
    {
        return $this->hasMany(RewardRecommendation::class, 'performance_result_id');
    }


    public function getPunishmentHistoryAttribute()
    {
        return PunishmentHistory::where('employee_id', $this->employee_id)
            ->where('period_id', $this->period_id)
            ->first();
    }

    public function latestRewardRecommendation()
    {
        return $this->hasOne(RewardRecommendation::class, 'performance_result_id')
            ->latestOfMany();
    }


    public function aiAnalysis()
    {
        return $this->hasOne(EmployeePerformanceAiAnalysis::class, 'performance_result_id');
    }

    public function latestAiAnalysis()
    {
        return $this->hasOne(EmployeePerformanceAiAnalysis::class, 'performance_result_id')
            ->latestOfMany();
    }

    // public function rewardRecommendation()
    // {
    //     return $this->hasOne(
    //         RewardRecommendation::class,
    //         'performance_result_id'
    //     );
    // }
}
