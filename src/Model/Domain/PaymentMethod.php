<?php

declare(strict_types=1);

namespace App\Model\Domain;

enum PaymentMethod: string
{
    case CASH = 'CASH';
    case CARD = 'CARD';
}
