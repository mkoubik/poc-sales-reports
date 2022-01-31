<?php

declare(strict_types=1);

namespace App\Model\Domain;

use Webmozart\Assert\Assert;

final class PaymentBill
{
    public function __construct(
        public readonly string $billId,
        public readonly \DateTimeInterface $createdAt,
        public readonly float $sale,
        public readonly PaymentMethod $paymentMethod,
    ) {
        Assert::greaterThan($this->sale, 0, 'sale has to be a positive float, got %s');
    }
}
