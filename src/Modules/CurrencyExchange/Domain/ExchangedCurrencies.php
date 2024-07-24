<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

readonly class ExchangedCurrencies
{
    public function __construct(private Currency $from, private Currency $to)
    {
        if ($this->from === $this->to) {
            throw new \InvalidArgumentException(sprintf('Currencies cannot be the same. Received both "%s"', $this->from->name));
        }
    }

    public function equals(ExchangedCurrencies $currencies): bool
    {
        if ($this->from !== $currencies->from) {
            return false;
        }

        if ($this->to !== $currencies->to) {
            return false;
        }

        return true;
    }

    public function getFrom(): Currency
    {
        return $this->from;
    }

    public function getTo(): Currency
    {
        return $this->to;
    }
}
