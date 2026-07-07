<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbcPopulation extends Model
{
    protected $fillable = [
        'period_id',
        'food_source',
        'fitness',
        'weight_json',
        'status',
    ];

    protected $casts = [
        'weight_json' => 'array',
        'fitness' => 'decimal:8',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
