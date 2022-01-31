<?php

declare(strict_types=1);

namespace App\Model\Fixtures;

final class DateGenerator
{
    private int $fromTimestamp;
    private int $toTimeStamp;

    public function __construct(\DateTimeInterface $from, \DateTimeInterface $to)
    {
        $this->fromTimestamp = $from->getTimestamp();
        $this->toTimeStamp = $to->getTimestamp();
    }

    public function generate(): \DateTimeImmutable
    {
        $timestamp = mt_rand($this->fromTimestamp, $this->toTimeStamp);

        return (new \DateTimeImmutable())->setTimestamp($timestamp);
    }
}
