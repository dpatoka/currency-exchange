<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;

readonly class Money
{
    public function __construct(private int $amount, private Currency $currency)
    {
        if ($this->amount < 1) {
            throw InvalidAmountException::fromAmount($this->amount);
        }
    }

    public function getAmount(): int
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

        if ($money->amount !== $this->amount) {
            return false;
        }

        return true;
    }
}
