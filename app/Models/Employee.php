<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'employee_code',
        'name',
        'photo',
        'gender',
        'religion',
        'email',
        'phone',
        'address',
        'birth_place',
        'birth_address',
        'department_id',
        'position_id',
        'leader_id',
        'join_date',
        'employment_status',
        'salary',
    ];

    protected $casts = [
        'join_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }


    /**
     * Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Position
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Leader (Atasan)
     */
    public function leader()
    {
        return $this->belongsTo(Employee::class, 'leader_id');
    }

    public function kpiScores()
    {
        return $this->hasMany(KpiScore::class, 'employee_id');
    }

    /**
     * Subordinates (Bawahan)
     */
    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'leader_id');
    }

    public function rewardHistories()
    {
        return $this->hasMany(RewardHistory::class);
    }

    public function punishmentHistories()
    {
        return $this->hasMany(PunishmentHistory::class);
    }

    public function coachingHistories()
    {
        return $this->hasMany(
            CoachingHistory::class,
            'employee_id'
        );
    }

    public function coachedEmployees()
    {
        return $this->hasMany(
            CoachingHistory::class,
            'coach_id'
        );
    }

    public function kpiValues()
    {
        return $this->hasMany(
            KpiIndicatorValue::class
        );
    }

    public function kpiIndicatorValues()
    {
        return $this->hasMany(
            KpiIndicatorValue::class
        );
    }
}
