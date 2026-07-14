<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiIndicator extends Model
{
    use HasFactory;

    protected $table = 'kpi_indicators';

    protected $fillable = [
        'kpi_master_id',
        'name',
        'description',
        'weight',
        'min_score',
        'max_score',
        'measurement_type',
        'is_active',
    ];


    protected $casts = [
        'weight' => 'decimal:2',
        'min_score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * KPI Master
     */
    public function master()
    {
        return $this->belongsTo(KpiMaster::class, 'kpi_master_id');
    }


    public function kpiMaster()
    {
        return $this->belongsTo(KpiMaster::class, 'kpi_master_id');
    }

    /**
     * Target KPI per karyawan
     */
    public function targets()
    {
        return $this->hasMany(KpiTarget::class, 'indicator_id');
    }


    public function values()
    {
        return $this->hasMany(
            KpiIndicatorValue::class,
            'kpi_indicator_id'
        );
    }

    /**
     * Realisasi KPI
     */
    // public function realizations()
    // {
    //     return $this->hasMany(KpiRealization::class, 'indicator_id');
    // }
}
