<?php

namespace App\Model\Fixtures;

use App\Model\Domain\PaymentBill;
use App\Model\Domain\PaymentMethod;
use App\Model\Func;
use Nette\Utils\Random;

final class BillsGenerator
{
    /**
     * @param callable(): float $saleGenerator
     */
    public function __construct(
        private DateGenerator $dateGenerator,
        private $saleGenerator,
    ) {}

    public static function create(): self
    {
        $dateGenerator = new DateGenerator(new \DateTimeImmutable('2021-01-01'), new \DateTimeImmutable('2022-01-01'));

        $saleGenerator = Func::map(
            FloatGenerator::normalDistribution(1000.00, 500.00),
            static fn (float $sale) => max(10.00, round($sale, 2)),
        );

        return new self(
            $dateGenerator,
            $saleGenerator,
        );
    }

    /**
     * @return \Generator<PaymentBill>
     */
    public function generate(int $count): \Generator
    {
        $generated = 0;
        while ($generated < $count) {
            yield $this->generateBill();
            $generated++;
        }
    }

    private function generateBill(): PaymentBill
    {
        $billId = 'bill_' . Random::generate(6);
        $createdAt = $this->dateGenerator->generate();
        $sale = call_user_func($this->saleGenerator);
        $paymentMethod = RandomGenerator::choice(PaymentMethod::cases());

        return new PaymentBill($billId, $createdAt, $sale, $paymentMethod);
    }
}
