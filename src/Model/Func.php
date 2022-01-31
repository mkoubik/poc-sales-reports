<?php

declare(strict_types=1);

namespace App\Model;

final class Func
{
    /**
     * @template TFrom
     * @template TTo
     * @param callable(): TFrom $fn
     * @param callable(TFrom): TTo $mapper
     * @return callable(): TTo
     */
    public static function map(callable $fn, callable $mapper): callable
    {
        return static function () use ($mapper, $fn) {
            return $mapper($fn());
        };
    }
}
