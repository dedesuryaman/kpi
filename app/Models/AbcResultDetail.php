<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbcResultDetail extends Model
{
    protected $fillable = [

        'abc_result_id',

        'kpi_master_id',

        'weight',

    ];

    protected $casts = [

        'weight' => 'float',

    ];

    public function abcResult()
    {
        return $this->belongsTo(AbcResult::class);
    }

    public function kpiMaster()
    {
        return $this->belongsTo(KpiMaster::class);
    }
}
