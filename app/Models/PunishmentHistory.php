<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PunishmentHistory extends Model
{
    use HasFactory;

    protected $table = 'punishment_history';

    protected $fillable = [
        'employee_id',
        'type',
        'severity',
        'notes',
        'approved_by',
        'period_id',
    ];

    /**
     * Karyawan
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * User approver
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

    /**
     * Scope
     */
    public function scopeSeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopePeriod($query, $periodId)
    {
        return $query->where('period_id', $periodId);
    }
}
