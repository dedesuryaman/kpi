<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingHistory extends Model
{
    use HasFactory;

    protected $table = 'coaching_history';

    protected $fillable = [
        'employee_id',
        'coach_id',
        'action',
        'result',
        'period_id',
    ];

    /**
     * Karyawan yang dibina
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Coach / Mentor
     */
    public function coach()
    {
        return $this->belongsTo(Employee::class, 'coach_id');
    }

    /**
     * Periode
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Scope
     */
    public function scopePeriod($query, $periodId)
    {
        return $query->where('period_id', $periodId);
    }

    public function scopeEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeCoach($query, $coachId)
    {
        return $query->where('coach_id', $coachId);
    }
}
