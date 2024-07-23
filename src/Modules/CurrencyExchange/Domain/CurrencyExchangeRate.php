<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;

readonly class CurrencyExchangeRate
{
    public function __construct(private ExchangedCurrencies $currencies, private int $amount)
    {
        if ($this->amount < 1) {
            throw InvalidAmountException::fromAmount($this->amount);
        }
    }

    public function getCurrencies(): ExchangedCurrencies
    {
        return $this->currencies;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function equals(CurrencyExchangeRate $rate): bool
    {
        if ($rate->amount !== $this->amount) {
            return false;
        }

        if ($rate->currencies->getFrom() !== $this->currencies->getFrom()) {
            return false;
        }

        if ($rate->currencies->getTo() !== $this->currencies->getTo()) {
            return false;
        }

        return true;
    }
}
