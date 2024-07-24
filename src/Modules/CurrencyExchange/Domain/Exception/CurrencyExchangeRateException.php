<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain\Exception;

use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;

class CurrencyExchangeRateException extends CurrencyExchangeException
{
    public static function notSupported(ExchangedCurrencies $currencies): self
    {
        return new self(
            sprintf(
                'Currency exchange rate from %s to %s not supported',
                $currencies->getFrom()->name,
                $currencies->getTo()->name
            )
        );
    }
}
