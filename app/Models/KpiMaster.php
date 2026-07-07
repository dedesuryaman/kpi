<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiMaster extends Model
{
    use HasFactory;

    protected $table = 'kpi_masters';

    protected $fillable = [

        'name',
        'description',
        'status',
        'created_by',
    ];



    /**
     * User pembuat KPI
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Detail KPI (indikator)
     */
    public function indicators()
    {
        return $this->hasMany(KpiIndicator::class, 'kpi_master_id');
    }

    public function abcResultDetails()
    {
        return $this->hasMany(AbcResultDetail::class);
    }
}
