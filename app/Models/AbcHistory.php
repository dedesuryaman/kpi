<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbcHistory extends Model
{
    protected $fillable = [
        'period_id',
        'before_weight',
        'after_weight',
        'improvement_score',
    ];

    protected $casts = [
        'before_weight' => 'array',
        'after_weight' => 'array',
        'improvement_score' => 'decimal:8',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
