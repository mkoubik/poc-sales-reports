<?php

declare(strict_types=1);

namespace App\Model\Elastic\Queries;

use App\Model\Elastic\Indices\SalesIndex;
use Elasticsearch\Client;

final class SalesQuery
{
    /** @var Filter[] */
    private $filters = [];

    public function addFilter(Filter $filter): void
    {
        $this->filters[] = $filter;
    }

    public function run(Client $client): array
    {
        return $client->search($this->toArray());
    }

    public function toArray(): array
    {
        $body = [
            'size' => 0,
            'aggs' => [
                'total_sales' => ['stats' => ['field' => 'sale']],
                'by_day_of_week' => [
                    'terms' => ['field' => 'date.day_of_week'],
                    'aggs' => [
                        'sales' => ['sum' => ['field' => 'sale']],
                    ],
                ],
                'by_month' => [
                    'date_histogram' => [
                        'field' => 'date.timestamp',
                        'calendar_interval' => 'month',
                        'format' => 'yyyy-MM',
                    ],
                    'aggs' => [
                        'sales' => ['sum' => ['field' => 'sale']],
                        'by_payment_method' => [
                            'terms' => ['field' => 'payment_method'],
                            'aggs' => [
                                'sales' => ['sum' => ['field' => 'sale']],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($this->filters as $filter) {
            $filter->addToQuery($body);
        }

        return [
            'index' => SalesIndex::INDEX,
            'body' => $body,
        ];
    }
}
