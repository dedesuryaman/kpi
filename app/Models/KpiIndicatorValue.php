<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiIndicatorValue extends Model
{
    protected $fillable = [
        'employee_id',
        'kpi_indicator_id',
        'weight',
        'target_value',
        'actual_value',
        'score',
        'remarks'
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'target_value' => 'decimal:2',
        'actual_value' => 'decimal:2',
        'score' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function indicator()
    {
        return $this->belongsTo(
            KpiIndicator::class,
            'kpi_indicator_id'
        );
    }

    protected static function booted()
    {
        static::saving(function ($model) {

            if (
                $model->target_value > 0 &&
                $model->actual_value !== null
            ) {
                $model->score =
                    ($model->actual_value /
                        $model->target_value)
                    * $model->weight;
            }
        });
    }
}
