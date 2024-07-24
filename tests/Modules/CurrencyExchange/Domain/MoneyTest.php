<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

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
        $money = Money::fromFloat(100, Currency::EUR);

        // when
        $result = $money->equals($example);

        // then
        self::assertEquals($expected, $result);
    }

    public function getExamples(): array
    {
        return [
            '100 EUR' => [Money::fromFloat(100, Currency::EUR), true],
            '1000 EUR' => [Money::fromFloat(1000, Currency::EUR), false],
            '100 GBP' => [Money::fromFloat(100, Currency::GBP), false],
        ];
    }
}
