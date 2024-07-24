<?php

namespace App\Tests\Modules\CurrencyExchange\Infrastructure\Adapter;

use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\CurrencyExchangeRate;
use App\Modules\CurrencyExchange\Domain\Exception\CurrencyExchangeRateException;
use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;
use App\Modules\CurrencyExchange\Infrastructure\Adapter\HardcodedCurrencyExchangeRateProvider;
use PHPUnit\Framework\TestCase;

class HardcodedCurrencyExchangeRateProviderTest extends TestCase
{
    /**
     * @dataProvider getExamples
     */
    public function testGetForCurrencies(ExchangedCurrencies $currencies, CurrencyExchangeRate $expected): void
    {
        // given
        $provider = new HardcodedCurrencyExchangeRateProvider();

        // when
        $result = $provider->getForCurrencies($currencies);

        // then
        self::assertTrue($expected->equals($result));
    }

    public function testGetForCurrenciesNotSupportedException(): void
    {
        $provider = new HardcodedCurrencyExchangeRateProvider();

        self::expectException(CurrencyExchangeRateException::class);

        $provider->getForCurrencies(new ExchangedCurrencies(
            Currency::EUR,
            Currency::ESP
        ));
    }

    public function getExamples(): array
    {
        return [
            [
                'currencies' => new ExchangedCurrencies(
                    Currency::EUR,
                    Currency::GBP
                ),
                'expected' => CurrencyExchangeRate::from(
                    Currency::EUR,
                    Currency::GBP,
                    1.5678
                ),
            ],
            [
                'currencies' => new ExchangedCurrencies(
                    Currency::GBP,
                    Currency::EUR
                ),
                'expected' => CurrencyExchangeRate::from(
                    Currency::GBP,
                    Currency::EUR,
                    1.5432
                ),
            ],
        ];
    }
}
