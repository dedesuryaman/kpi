<?php

namespace App\Services\ABC;

use App\Services\ABC\Concerns\NormalizesSolution;

class OnlookerBee
{
    use NormalizesSolution;

    public function run(
        array &$population,
        $scores,
        array $masters
    ): void {

        $fitness = new Fitness();

        $totalFitness = array_sum(
            array_map(
                fn($bee) => $bee->fitness,
                $population
            )
        );

        if ($totalFitness <= 0) {
            return;
        }

        foreach ($population as $bee) {

            $bee->probability =
                $bee->fitness / $totalFitness;
        }

        $size = count($population);

        for ($i = 0; $i < $size; $i++) {

            $r = mt_rand() / mt_getrandmax();

            $selected = null;

            foreach ($population as $bee) {

                if ($r <= $bee->probability) {

                    $selected = $bee;
                    break;
                }

                $r -= $bee->probability;
            }

            if (!$selected) {
                continue;
            }

            $k = rand(0, $size - 1);

            $newSolution = $selected->solution;

            foreach ($newSolution as $j => $value) {

                $phi = (mt_rand() / mt_getrandmax()) * 2 - 1;

                $newSolution[$j] =
                    $value +
                    $phi *
                    (
                        $value -
                        $population[$k]->solution[$j]
                    );

                $newSolution[$j] =
                    max(
                        0.000001,
                        $newSolution[$j]
                    );
            }

            $newSolution =
                $this->normalize($newSolution);

            $newFitness =
                $fitness->calculate(
                    $newSolution,
                    $scores,
                    $masters
                );

            if ($newFitness > $selected->fitness) {

                $selected->solution = $newSolution;
                $selected->fitness = $newFitness;
                $selected->trial = 0;
            } else {

                $selected->trial++;
            }
        }
    }
}
