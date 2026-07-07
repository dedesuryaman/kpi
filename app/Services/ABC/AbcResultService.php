<?php

namespace App\Services\ABC;

use App\Models\AbcResult;
use App\Models\AbcResultDetail;
use Illuminate\Support\Facades\DB;

class AbcResultService
{
    public function store(
        int $periodId,
        array $result
    ): AbcResult {

        return DB::transaction(function () use (
            $periodId,
            $result
        ) {

            AbcResult::where('period_id', $periodId)
                ->update([
                    'is_best' => false,
                ]);

            $abcResult = AbcResult::create([

                'period_id' => $periodId,

                'population_size' => $result['population_size'],

                'max_iteration' => $result['max_iteration'],

                'limit_trial' => $result['limit_trial'],

                'fitness' => $result['fitness'],

                'execution_time' => $result['execution_time'],

                'is_best' => true,

            ]);

            foreach ($result['weights'] as $weight) {

                $abcResult->details()->create([

                    'kpi_master_id' => $weight['kpi_master_id'],

                    'weight' => $weight['weight'],

                ]);
            }

            return $abcResult;
        });
    }
}
