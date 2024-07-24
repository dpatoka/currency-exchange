<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

readonly class Money
{
    private function __construct(private Amount $amount, private Currency $currency)
    {
    }

    public static function from(float $amount, Currency $currency): self
    {
        return new self(
            new Amount($amount),
            $currency
        );
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function equals(Money $money): bool
    {
        if ($money->currency !== $this->currency) {
            return false;
        }

        if ($money->amount->getValue() !== $this->amount->getValue()) {
            return false;
        }

        return true;
    }
}
