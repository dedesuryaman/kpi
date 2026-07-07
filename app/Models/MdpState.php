<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdpState extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'min_score',
        'max_score',
        'color',
        'description',
        'status'
    ];

    public function transitionsFrom()
    {
        return $this->hasMany(MdpTransitionProbability::class, 'from_state_id');
    }

    public function transitionsTo()
    {
        return $this->hasMany(MdpTransitionProbability::class, 'to_state_id');
    }

    public function analyses()
    {
        return $this->hasMany(MdpAnalysisResult::class, 'state_id');
    }
}