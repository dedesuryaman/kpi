<?php

namespace App\Services\ABC;

use App\Models\KpiMaster;
use App\Models\KpiScore;

class DataPreprocessor
{
    public function build(int $periodId): array
    {
        $masters = KpiMaster::where('status', 1)
            ->orderBy('id')
            ->get();

        $scores = KpiScore::query()
            ->with('indicator')
            ->where('period_id', $periodId)
            ->get();

        $matrix = [];

        foreach ($scores as $score) {

            $masterId = $score->indicator->kpi_master_id;

            $matrix[$score->employee_id][$masterId][] =
                (float) $score->score;
        }

        foreach ($matrix as $employeeId => $masterScores) {

            foreach ($masterScores as $masterId => $values) {

                $matrix[$employeeId][$masterId] =
                    array_sum($values) / count($values);
            }
        }

        return [

            'masters' => $masters,

            'matrix' => $matrix,

        ];
    }
}
