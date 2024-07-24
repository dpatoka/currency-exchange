<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Infrastructure\Adapter;

use App\Modules\CurrencyExchange\Domain\Amount;
use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\CurrencyExchangeRate;
use App\Modules\CurrencyExchange\Domain\Exception\CurrencyExchangeRateException;
use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;
use App\Modules\CurrencyExchange\Domain\Port\CurrencyExchangeRateProvider;

/**
 * This is a naive implementation for task purposes.
 * Real-life scenario will fetch data from some source.
 */
readonly class HardcodedCurrencyExchangeRateProvider implements CurrencyExchangeRateProvider
{
    public function getForCurrencies(ExchangedCurrencies $currencies): CurrencyExchangeRate
    {
        if ($currencies->equals(new ExchangedCurrencies(Currency::EUR, Currency::GBP))) {
            return new CurrencyExchangeRate(
                $currencies,
                new Amount(1.5678)
            );
        }

        if ($currencies->equals(new ExchangedCurrencies(Currency::GBP, Currency::EUR))) {
            return new CurrencyExchangeRate(
                $currencies,
                new Amount(1.5432)
            );
        }

        throw CurrencyExchangeRateException::notSupported($currencies);
    }
}
