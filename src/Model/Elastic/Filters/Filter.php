<?php

declare(strict_types=1);

namespace App\Model\Elastic\Queries;

interface Filter
{
    public function addToQuery(array &$body): void;
}
