<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;

readonly class Amount
{
    private const int PRECISION = 100000;
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

    public function add(Amount $amount): self
    {
        $intResult = $this->value + $amount->value;

        return $this->createFromInteger($intResult);
    }

    public function subtract(Amount $amount): self
    {
        $intResult = $this->value - $amount->value;

        return $this->createFromInteger($intResult);
    }

    public function multiply(Amount $amount): self
    {
        $intResult = $this->value * $amount->value;

        return new Amount(
            $intResult / self::PRECISION / self::PRECISION
        );
    }

    public function divide(Amount $amount): self
    {
        $intResult = $this->value / $amount->value;

        return new Amount(
            $intResult
        );
    }

    private function toInt(float $value): int
    {
        return (int) ($value * self::PRECISION);
    }

    private function createFromInteger(int $amount): Amount // TODO to delete?
    {
        return new Amount(
            $this->toFloat($amount)
        );
    }

    private function toFloat(int $value): float
    {
        $floatValue = $value / self::PRECISION;

        return round($floatValue, 4);
    }
}
