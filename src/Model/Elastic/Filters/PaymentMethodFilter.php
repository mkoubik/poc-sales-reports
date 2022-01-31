<?php

declare(strict_types=1);

namespace App\Model\Elastic\Queries;

use App\Model\Domain\PaymentMethod;

final class PaymentMethodFilter implements Filter
{
    public function __construct(private PaymentMethod $paymentMethod)
    {
    }

    public function addToQuery(array &$body): void
    {
        $body['query']['bool']['must']['match']['payment_method'] = $this->paymentMethod;
    }
}
