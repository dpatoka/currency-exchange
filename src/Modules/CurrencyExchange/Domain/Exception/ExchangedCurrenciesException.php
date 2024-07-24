<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain\Exception;

use App\Modules\CurrencyExchange\Domain\Currency;

class ExchangedCurrenciesException extends CurrencyExchangeException
{
    public static function sameCurrencies(Currency $from, Currency $to): self
    {
        return new self(
            sprintf(
                'Currency exchange rate from %s to %s not supported',
                $from->name,
                $to->name
            )
        );
    }
}
