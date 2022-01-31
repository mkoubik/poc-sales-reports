<?php

declare(strict_types=1);

namespace App\Model\Fixtures;

final class IntGenerator
{
    /**
     * @return \Closure(): int
     */
    public static function id(): \Closure
    {
        return self::sequence(from: 1);
    }

    /**
     * @return \Closure(): int
     */
    public static function sequence(int $from = 0): \Closure
    {
        return function () use (&$from): int {
            return $from++;
        };
    }
}
