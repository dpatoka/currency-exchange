<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\ExchangedCurrencies;
use PHPUnit\Framework\TestCase;

class ExchangedCurrenciesTest extends TestCase
{
    /**
     * @dataProvider getImproperData
     */
    public function testCreationWithImproperValues(Currency $from, Currency $to): void
    {
        self::expectException(\InvalidArgumentException::class);

        $money = new ExchangedCurrencies($from, $to);
    }

    /**
     * @dataProvider getValidData
     */
    public function testCreationWithValidValues(Currency $from, Currency $to): void
    {
        $money = new ExchangedCurrencies($from, $to);

        self::assertInstanceOf(ExchangedCurrencies::class, $money);
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
}
