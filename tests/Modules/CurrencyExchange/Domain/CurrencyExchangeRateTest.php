<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Amount;
use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\CurrencyExchangeRate;
use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeRateTest extends TestCase
{
    /**
     * @dataProvider getExamples
     */
    public function testEqualsWithProperValues(CurrencyExchangeRate $example, bool $expected): void
    {
        // given
        $exchangeRate = new CurrencyExchangeRate(
            new ExchangedCurrencies(
                Currency::EUR,
                Currency::GBP
            ),
            new Amount(1.5678)
        );

        // when
        $result = $exchangeRate->equals($example);

        // then
        self::assertEquals($result, $expected);
    }

    public function getExamples(): array
    {
        return [
            [
                'example' => new CurrencyExchangeRate(
                    new ExchangedCurrencies(
                        Currency::EUR,
                        Currency::GBP
                    ),
                    new Amount(1.5678)
                ),
                'expected' => true,
            ],
            [
                'example' => new CurrencyExchangeRate(
                    new ExchangedCurrencies(
                        Currency::EUR,
                        Currency::GBP
                    ),
                    new Amount(1.5677)
                ),
                'expected' => false,
            ],
            [
                'example' => new CurrencyExchangeRate(
                    new ExchangedCurrencies(
                        Currency::GBP,
                        Currency::EUR
                    ),
                    new Amount(1.5678)
                ),
                'expected' => false,
            ],
        ];
    }
}
