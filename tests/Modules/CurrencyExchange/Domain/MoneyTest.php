<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Amount;
use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @dataProvider getExamples
     */
    public function testEquals(Money $example, bool $expected): void
    {
        // given
        $money = new Money(new Amount(100), Currency::EUR);

        // when
        $result = $money->equals($example);

        // then
        self::assertEquals($expected, $result);
    }

    public function getExamples(): array
    {
        return [
            '100 EUR' => [new Money(new Amount(100), Currency::EUR), true],
            '1000 EUR' => [new Money(new Amount(1000), Currency::EUR), false],
            '100 GBP' => [new Money(new Amount(100), Currency::GBP), false],
        ];
    }
}
