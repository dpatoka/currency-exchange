<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;

readonly class Amount
{
    private const int PRECISION = 10000;
    private int $value;

    public function __construct(float $floatValue)
    {
        $intValue = $this->toInt($floatValue);

        if ($intValue < 1) {
            throw InvalidAmountException::fromAmount($intValue);
        }

        $this->value = $intValue;
    }

    public function getValue(): float
    {
        return $this->toFloat($this->value);
    }

    public function multiply(Amount $amount): self
    {
        $intResult = $this->value * $amount->value;

        return new Amount(
            $intResult / self::PRECISION / self::PRECISION
        );
    }

    private function toInt(float $value): int
    {
        return (int) ($value * self::PRECISION);
    }

    private function toFloat(int $value): float
    {
        return $value / self::PRECISION;
    }
}
