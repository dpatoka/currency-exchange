<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\Exception\ExchangedCurrenciesException;
use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;
use PHPUnit\Framework\TestCase;

class ExchangedCurrenciesTest extends TestCase
{
    /**
     * @dataProvider getImproperData
     */
    public function testCreationWithImproperValues(Currency $from, Currency $to): void
    {
        self::expectException(ExchangedCurrenciesException::class);

        $exchangedCurrencies = new ExchangedCurrencies($from, $to);
    }

    /**
     * @dataProvider getValidData
     */
    public function testCreationWithValidValues(Currency $from, Currency $to): void
    {
        $exchangedCurrencies = new ExchangedCurrencies($from, $to);

        self::assertInstanceOf(ExchangedCurrencies::class, $exchangedCurrencies);
    }

    /**
     * @dataProvider getEqualsData
     */
    public function testEquals(Currency $from, Currency $to, bool $expected): void
    {
        // given
        $exchangedCurrencies = new ExchangedCurrencies(Currency::GBP, Currency::EUR);

        // when
        $result = $exchangedCurrencies->equals(new ExchangedCurrencies($from, $to));

        // then
        self::assertEquals($expected, $result);
    }

    public function getImproperData(): array
    {
        return [
            [Currency::GBP, Currency::GBP],
            [Currency::EUR, Currency::EUR],
        ];
    }

    public function getValidData(): array
    {
        return [
            [Currency::GBP, Currency::EUR],
            [Currency::EUR, Currency::GBP],
        ];
    }

    public function getEqualsData()
    {
        return [
            [Currency::GBP, Currency::EUR, true],
            [Currency::EUR, Currency::GBP, false],
        ];
    }
}
