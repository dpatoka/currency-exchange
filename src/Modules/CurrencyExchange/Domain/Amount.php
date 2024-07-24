<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\BuildingBlocks\Domain\ValueObject;
use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;

readonly class Amount implements ValueObject
{
    private const int NUMBER_FOR_CONVERTING_TO_INTEGER = 100000;
    private const int FLOAT_PRECISION = 4;
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
            $intResult / self::NUMBER_FOR_CONVERTING_TO_INTEGER / self::NUMBER_FOR_CONVERTING_TO_INTEGER
        );
    }

    public function divide(Amount $amount): self
    {
        $result = $this->value / $amount->value;

        return new Amount(
            $result
        );
    }

    private function toInt(float $value): int
    {
        return (int) ($value * self::NUMBER_FOR_CONVERTING_TO_INTEGER);
    }

    private function createFromInteger(int $amount): Amount
    {
        return new Amount(
            $this->toFloat($amount)
        );
    }

    private function toFloat(int $value): float
    {
        $floatValue = $value / self::NUMBER_FOR_CONVERTING_TO_INTEGER;

        return round($floatValue, self::FLOAT_PRECISION);
    }
}
