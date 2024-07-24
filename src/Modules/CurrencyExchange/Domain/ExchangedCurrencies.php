<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\BuildingBlocks\Domain\ValueObject;
use App\Modules\CurrencyExchange\Domain\Exception\ExchangedCurrenciesException;

readonly class ExchangedCurrencies implements ValueObject
{
    public function __construct(private Currency $from, private Currency $to)
    {
        if ($this->from === $this->to) {
            throw ExchangedCurrenciesException::sameCurrencies($from, $to);
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
