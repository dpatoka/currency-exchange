<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Infrastructure\Adapter;

use App\Modules\CurrencyExchange\Domain\Amount;
use App\Modules\CurrencyExchange\Domain\Port\FeeProvider;

/**
 * This is a naive implementation for task purposes.
 * Real-life scenario will fetch data from some source.
 */
readonly class HardcodedFeeProvider implements FeeProvider
{
    public function getPercentage(): Amount
    {
        return new Amount(0.01);
    }
}
