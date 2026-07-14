<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePerformanceAiAnalysis extends Model
{
    use HasFactory;

    protected $table = 'employee_performance_ai_analysis';

    protected $fillable = [
        'performance_result_id',
        'provider',
        'model',
        'summary',
        'strengths',
        'weaknesses',
        'opportunities',
        'risks',
        'recommendation',
        'reward_recommendation',
        'punishment_recommendation',
        'overall_score',
        'confidence',
        'prompt',
        'response',
        'analyzed_at',
    ];

    protected $casts = [
        'overall_score' => 'decimal:2',
        'confidence'    => 'decimal:2',
        'analyzed_at'   => 'datetime',
    ];

    /**
     * Relasi ke EmployeePerformanceResult
     */
    public function performance()
    {
        return $this->belongsTo(
            EmployeePerformanceResult::class,
            'performance_result_id'
        );
    }
}
