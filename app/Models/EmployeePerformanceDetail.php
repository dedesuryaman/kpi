<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePerformanceDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_performance_details';

    protected $fillable = [
        'performance_result_id',
        'kpi_master_id',
        'score',
        'weight',
        'weighted_score',
    ];

    protected $casts = [
        'score' => 'float',
        'weight' => 'float',
        'weighted_score' => 'float',
    ];

    public function depaartment()
    {
        return $this->belongsTo(
            Department::class,
            'department_id'
        );
    }


    /**
     * Header Result
     */
    public function result()
    {
        return $this->belongsTo(
            EmployeePerformanceResult::class,
            'performance_result_id'
        );
    }

    /**
     * KPI Master
     */
    public function kpiMaster()
    {
        return $this->belongsTo(
            KpiMaster::class,
            'kpi_master_id'
        );
    }

    public function performanceResult()
    {
        return $this->belongsTo(
            EmployeePerformanceResult::class,
            'performance_result_id'
        );
    }
}
