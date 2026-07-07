<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardHistory extends Model
{
    use HasFactory;

    protected $table = 'reward_history';

    protected $fillable = [
        'employee_id',
        'type',
        'description',
        'approved_by',
        'approved_at',
        'period_id',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Karyawan
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * User Approver
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Periode
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function scopeReward($query)
    {
        return $query->where('type', 'reward');
    }

    public function scopePunishment($query)
    {
        return $query->where('type', 'punishment');
    }

    public function scopePeriod($query, $periodId)
    {
        return $query->where('period_id', $periodId);
    }
}
