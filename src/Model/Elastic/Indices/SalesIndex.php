<?php

declare(strict_types=1);

namespace App\Model\Elastic\Indices;

use App\Model\Domain\PaymentBill;
use Elasticsearch\Client;

final class SalesIndex
{
    public const INDEX = 'app_sales';

    public function __construct(public Client $client)
    {
    }

    public function recreate(): void
    {
        $this->client->indices()->delete([
            'index' => self::INDEX,
            'ignore_unavailable' => true,
        ]);

        $this->client->indices()->create([
            'index' => self::INDEX,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'date' => [
                            'properties' => [
                                'timestamp' => ['type' => 'date'],
                                'month' => ['type' => 'keyword'],
                                'day_of_week' => ['type' => 'keyword'],
                            ],
                        ],
                        'sale' => ['type' => 'float'],
                        'payment_method' => ['type' => 'keyword'],
                    ],
                ],
            ],
        ]);
    }

    public function put(PaymentBill $bill): void
    {
        $this->client->index([
            'index' => self::INDEX,
            'id' => $bill->billId,
            'body' => [
                'date' => [
                    'timestamp' => $bill->createdAt->getTimestamp() * 1000,
                    'month' => $bill->createdAt->format('Y-m'),
                    'day_of_week' => $bill->createdAt->format('l'),
                ],
                'sale' => $bill->sale,
                'payment_method' => $bill->paymentMethod,
            ],
        ]);
    }
}
