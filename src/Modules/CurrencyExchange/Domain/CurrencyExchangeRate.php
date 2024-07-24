<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

readonly class CurrencyExchangeRate
{
    public function __construct(private ExchangedCurrencies $currencies, private Amount $amount)
    {
    }

    public function getCurrencies(): ExchangedCurrencies
    {
        return $this->currencies;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function equals(CurrencyExchangeRate $rate): bool
    {
        if ($rate->amount->getValue() !== $this->amount->getValue()) {
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
