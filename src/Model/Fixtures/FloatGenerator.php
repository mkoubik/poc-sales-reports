<?php

namespace App\Model\Fixtures;

final class FloatGenerator
{
    /**
     * @return \Closure(): float
     */
    public static function normalDistribution(float $mean, float $sd): \Closure
    {
        return function () use ($mean, $sd): float {
            $x = mt_rand() / mt_getrandmax();
            $y = mt_rand() / mt_getrandmax();

            return sqrt(-2 * log($x)) * cos(2 * pi() * $y) * $sd + $mean;
        };
    }
}
