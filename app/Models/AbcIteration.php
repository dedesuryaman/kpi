<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbcIteration extends Model
{
    protected $fillable = [
        'period_id',
        'iteration',
        'best_fitness',
        'avg_fitness',
        'convergence_rate',
    ];

    protected $casts = [
        'best_fitness' => 'decimal:8',
        'avg_fitness' => 'decimal:8',
        'convergence_rate' => 'decimal:6',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
