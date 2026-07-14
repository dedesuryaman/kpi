<?php

namespace App\Services\ABC;

use Illuminate\Support\Collection;

class Fitness
{
    /**
     * Menghitung fitness kandidat bobot ABC.
     */
    public function calculate(
        array $solution,
        Collection $scores,
        array $masters
    ): float {

        /*
        |--------------------------------------------------------------------------
        | GROUP DATA
        |--------------------------------------------------------------------------
        */

        $employees = [];


        foreach ($scores as $score) {

            $masterId = $score->indicator->kpi_master_id ?? null;

            if (!$masterId) {
                continue;
            }

            $employees[$score->employee_id][$masterId][] = $score->score;
        }



        /*
        |--------------------------------------------------------------------------
        | HITUNG FINAL SCORE TIAP KARYAWAN
        |--------------------------------------------------------------------------
        */

        $finalScores = [];

        foreach ($employees as $employeeScores) {

            $final = 0;

            foreach ($masters as $index => $master) {




                $masterId = $master->id;

                $values = $employeeScores[$masterId] ?? [];

                if (count($values) == 0) {
                    continue;
                }

                $avg = array_sum($values) / count($values);

                $weight = $solution[$index];

                $final += $avg * $weight;
            }

            $finalScores[] = $final;
        }



        if (count($finalScores) == 0) {
            return 0;
        }

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA FINAL SCORE
        |--------------------------------------------------------------------------
        */

        $averageFinal =
            array_sum($finalScores) /
            count($finalScores);

        /*
        |--------------------------------------------------------------------------
        | VARIANCE BOBOT
        |--------------------------------------------------------------------------
        */

        $weightMean =
            array_sum($solution) /
            count($solution);

        $variance = 0;

        $penalty = 0;

        foreach ($solution as $weight) {

            if ($weight < 0.05) {
                $penalty += 100;
            }

            $variance += pow(
                $weight - $weightMean,
                2
            );
        }

        $variance /= count($solution);

        /*
        |--------------------------------------------------------------------------
        | FITNESS
        |--------------------------------------------------------------------------
        */

        $lambda = 5;

        $fitness =
            $averageFinal
            - ($lambda * $variance)
            - $penalty;

        // $fitness =
        //     $averageFinal -
        //     ($lambda * $variance);

        return round($fitness, 6);
    }
}
