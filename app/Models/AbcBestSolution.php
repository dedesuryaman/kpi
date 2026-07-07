<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbcBestSolution extends Model
{
    protected $fillable = [
        'period_id',
        'best_weight_json',
        'fitness_score',
        'generated_at',
    ];

    protected $casts = [
        'best_weight_json' => 'array',
        'fitness_score' => 'decimal:8',
        'generated_at' => 'datetime',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
