<?php

namespace App\Services\ABC;

use App\Services\ABC\Concerns\NormalizesSolution;

class ScoutBee
{
    use NormalizesSolution;

    public function run(
        array &$population,
        $scores,
        int $limit,
        array $masters
    ): void {

        $fitness = new Fitness();

        foreach ($population as $bee) {

            if ($bee->trial < $limit) {
                continue;
            }

            $dimension =
                count($bee->solution);

            $solution = [];

            for ($i = 0; $i < $dimension; $i++) {

                $solution[] =
                    mt_rand(1, 1000);
            }

            $solution =
                $this->normalize($solution);

            $bee->solution = $solution;

            $bee->fitness =
                $fitness->calculate(
                    $solution,
                    $scores,
                    $masters
                );

            $bee->trial = 0;
        }
    }
}
