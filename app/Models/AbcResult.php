<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbcResult extends Model
{
    protected $fillable = [
        'period_id',
        'population_size',
        'max_iteration',
        'limit_trial',
        'fitness',

        'attendance_weight',
        'productivity_weight',
        'quality_weight',
        'discipline_weight',
        'innovation_weight',

        'execution_time',
        'is_best',
    ];

    protected $casts = [
        'fitness' => 'float',

        'attendance_weight' => 'float',
        'productivity_weight' => 'float',
        'quality_weight' => 'float',
        'discipline_weight' => 'float',
        'innovation_weight' => 'float',
    ];

    public function details()
    {
        return $this->hasMany(AbcResultDetail::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
