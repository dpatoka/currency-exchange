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
    public function testEqualsWithProperValues(Money $example, bool $expected): void
    {
        // given
        $money = new Money(100, Currency::EUR);

        // when
        $result = $money->equals($example);

        // then
        self::assertEquals($result, $expected);
    }

    /**
     * @dataProvider getExamplesWithImproperValues
     */
    public function testEqualsWithImProperValues(int $amount): void
    {
        self::expectException(\InvalidArgumentException::class);

        $money = new Money($amount, Currency::EUR);
    }

    public function getExamples(): array
    {
        return [
            [new Money(100, Currency::EUR), true],
            [new Money(1000, Currency::EUR), false],
            [new Money(100, Currency::GBP), false],
        ];
    }

    public function getExamplesWithImproperValues(): array
    {
        return [
            [0],
            [-100],
        ];
    }
}
