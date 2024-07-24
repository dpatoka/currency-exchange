<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain\Port;

use App\Modules\CurrencyExchange\Domain\Amount;

interface FeeProvider
{
    public function getPercentage(): Amount;
}
