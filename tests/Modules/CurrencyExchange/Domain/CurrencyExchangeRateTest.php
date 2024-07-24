<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\CurrencyExchangeRate;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeRateTest extends TestCase
{
    /**
     * @dataProvider getExamples
     */
    public function testEqualsWithProperValues(CurrencyExchangeRate $example, bool $expected): void
    {
        // given
        $exchangeRate = CurrencyExchangeRate::from(
            Currency::EUR,
            Currency::GBP,
            1.5678
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
                'example' => CurrencyExchangeRate::from(
                    Currency::EUR,
                    Currency::GBP,
                    1.5678
                ),
                'expected' => true,
            ],
            [
                'example' => CurrencyExchangeRate::from(
                    Currency::EUR,
                    Currency::GBP,
                    1.5677
                ),
                'expected' => false,
            ],
            [
                'example' => CurrencyExchangeRate::from(
                    Currency::GBP,
                    Currency::EUR,
                    1.5678
                ),
                'expected' => false,
            ],
        ];
    }
}
