<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiScore extends Model
{
    use HasFactory;

    protected $table = 'kpi_scores';

    protected $fillable = [
        'employee_id',
        'indicator_id',
        'score',
        'final_score',
        'assessor_id',
        'assessment_date',
        'notes',
        'period_id',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'final_score' => 'decimal:2',
        'assessment_date' => 'date',
    ];

    /**
     * Karyawan yang dinilai
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * KPI Indicator
     */
    // public function indicator()
    // {
    //     return $this->belongsTo(KpiIndicator::class, 'indicator_id');
    // }



    /**
     * User penilai
     */
    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    /**
     * Periode penilaian
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function indicator()
    {
        return $this->belongsTo(
            KpiIndicator::class,
            'indicator_id'
        );
    }
}
