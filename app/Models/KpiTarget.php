<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiTarget extends Model
{
    use HasFactory;

    protected $table = 'kpi_targets';

    protected $fillable = [
        'employee_id',
        'indicator_id',
        'target_value',
        'period_id',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
    ];

    /**
     * Karyawan yang memiliki target KPI
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Indikator KPI
     */
    public function indicator()
    {
        return $this->belongsTo(KpiIndicator::class);
    }

    /**
     * Periode KPI
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
