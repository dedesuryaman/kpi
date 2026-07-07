<?php

namespace App\Services\ABC\Concerns;

trait NormalizesSolution
{
    protected function normalize(array $solution): array
    {
        foreach ($solution as &$value) {

            $value = max(
                0.000001,
                $value
            );
        }

        unset($value);

        $sum = array_sum($solution);

        if ($sum <= 0) {

            return array_fill(
                0,
                count($solution),
                1 / count($solution)
            );
        }

        foreach ($solution as &$value) {

            $value /= $sum;
        }

        unset($value);

        return $solution;
    }
}
