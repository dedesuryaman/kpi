<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function kpiMasters()
    {
        return $this->hasMany(KpiMaster::class);
    }

    public function kpiTargets()
    {
        return $this->hasMany(KpiTarget::class);
    }

    public function kpiScores()
    {
        return $this->hasMany(KpiScore::class);
    }

    public function abcPopulations()
    {
        return $this->hasMany(AbcPopulation::class);
    }

    public function abcIterations()
    {
        return $this->hasMany(AbcIteration::class);
    }

    public function mdpPolicies()
    {
        return $this->hasMany(MdpPolicy::class);
    }

    public function rewardHistories()
    {
        return $this->hasMany(RewardHistory::class);
    }

    public function punishmentHistories()
    {
        return $this->hasMany(PunishmentHistory::class);
    }


    public function coachingHistories()
    {
        return $this->hasMany(CoachingHistory::class);
    }
}
