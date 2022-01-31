<?php

namespace App\Model\Fixtures;

final class RandomGenerator
{
    /**
     * @template T
     * @param T[] $choices
     * @return T
     */
    public static function choice(array $choices): mixed
    {
        $i = mt_rand(0, count($choices) - 1);

        return $choices[$i];
    }
}
