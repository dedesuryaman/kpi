<?php

namespace App\Services\ABC;

class Population
{
    /**
     * Generate initial population.
     *
     * @param int $populationSize
     * @param int $dimension Jumlah KPI Master
     * @return Bee[]
     */
    public function generate(
        int $populationSize,
        int $dimension
    ): array {

        $population = [];

        for ($i = 0; $i < $populationSize; $i++) {

            $bee = new Bee();

            $weights = [];

            // Generate random weight
            for ($j = 0; $j < $dimension; $j++) {
                $weights[] = mt_rand(1, 1000);
            }

            // Normalisasi agar total = 1
            $sum = array_sum($weights);

            foreach ($weights as &$weight) {
                $weight = $weight / $sum;
            }

            unset($weight);

            $bee->solution = $weights;
            $bee->fitness = 0;
            $bee->trial = 0;

            $population[] = $bee;
        }

        return $population;
    }
}
