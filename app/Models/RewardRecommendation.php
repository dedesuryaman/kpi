<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardRecommendation extends Model
{
    use HasFactory;


    const STATUS_PENDING  = 'Pending';
    const STATUS_APPROVED = 'Approved';
    const STATUS_REJECTED = 'Rejected';

    const TYPE_PROMOTION        = 'Promotion';

    const TYPE_SALARY_INCREASE  = 'Salary Increase';

    const TYPE_PERFORMANCE_BONUS = 'Performance Bonus';

    const TYPE_CERTIFICATE      = 'Certificate';

    protected $fillable = [

        'performance_result_id',

        'reward_type',

        'status',

        'effective_date',

        'approval_notes',

        'approved_by',

        'approved_at',

    ];

    protected $casts = [

        'effective_date' => 'date',

        'approved_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function performanceResult()
    {
        return $this->belongsTo(
            EmployeePerformanceResult::class,
            'performance_result_id'
        );
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
