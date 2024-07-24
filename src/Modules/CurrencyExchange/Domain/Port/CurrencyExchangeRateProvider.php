<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain\Port;

use App\Modules\CurrencyExchange\Domain\CurrencyExchangeRate;
use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;

interface CurrencyExchangeRateProvider
{
    public function getForCurrencies(ExchangedCurrencies $currencies): CurrencyExchangeRate;
}
