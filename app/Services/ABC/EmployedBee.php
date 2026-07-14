<?php

namespace App\Services\ABC;

use App\Services\ABC\Fitness;

class EmployedBee
{
    public function run(array &$population, $scores, array $masters): void
    {
        $fitness = new Fitness();

        $size = count($population);

        foreach ($population as $i => $bee) {

            /*
            |-----------------------------------------
            | PILIH NEIGHBOR RANDOM (k ≠ i)
            |-----------------------------------------
            */

            $k = rand(0, $size - 1);

            while ($k === $i) {
                $k = rand(0, $size - 1);
            }

            $newSolution = $bee->solution;

            /*
            |-----------------------------------------
            | UPDATE SOLUSI (RUMUS ABC)
            |-----------------------------------------
            */

            foreach ($newSolution as $j => $value) {

                $phi = (mt_rand() / mt_getrandmax()) * 2 - 1;

                $newSolution[$j] =
                    $value +
                    $phi * (
                        $value -
                        $population[$k]->solution[$j]
                    );

                // jangan biarkan negatif
                $newSolution[$j] = max(0.000001, $newSolution[$j]);
            }

            // NORMALISASI
            $newSolution = $this->normalize($newSolution);
            /*
            |-----------------------------------------
            | HITUNG FITNESS
            |-----------------------------------------
            */

            $newFitness = $fitness->calculate(
                $newSolution,
                $scores,
                $masters
            );

            /*
            |-----------------------------------------
            | GREEDY SELECTION
            |-----------------------------------------
            */

            if ($newFitness > $bee->fitness) {

                $population[$i]->solution = $newSolution;
                $population[$i]->fitness = $newFitness;
            }
        }
    }

    private function normalize(array $solution): array
    {
        $minimum = 0.05;

        foreach ($solution as &$value) {

            $value = max(
                $minimum,
                $value
            );
        }

        unset($value);

        $sum = array_sum($solution);

        foreach ($solution as &$value) {

            $value /= $sum;
        }

        return $solution;
    }

    private function normalize_v1(array $solution): array
    {
        $minWeight = 0.05; // 5%

        $count = count($solution);

        foreach ($solution as &$value) {
            $value = max($minWeight, $value);
        }

        $sum = array_sum($solution);

        foreach ($solution as &$value) {
            $value /= $sum;
        }

        return $solution;
    }

    private function normalize_old(array $solution): array
    {
        $sum = array_sum($solution);

        if ($sum <= 0) {

            $count = count($solution);

            return array_fill(
                0,
                $count,
                1 / $count
            );
        }

        foreach ($solution as &$value) {

            $value /= $sum;
        }

        return $solution;
    }
}
