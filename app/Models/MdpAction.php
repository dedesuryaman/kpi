<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdpAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'color',
        'status'
    ];

    public function analyses()
    {
        return $this->hasMany(MdpAnalysisResult::class, 'action_id');
    }
}
