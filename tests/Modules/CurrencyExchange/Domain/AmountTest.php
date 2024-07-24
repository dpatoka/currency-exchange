<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Amount;
use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    /**
     * @dataProvider getExamples
     */
    public function testFromFloat(float $example, float $expected): void
    {
        // when
        $result = new Amount($example);

        // then
        self::assertEquals($expected, $result->getValue());
    }

    /**
     * @dataProvider getExamplesWithImproperValues
     */
    public function testFromFloatWithImProperValues(float $example): void
    {
        self::expectException(InvalidAmountException::class);

        new Amount($example);
    }

    /**
     * @dataProvider multiplyExamples
     */
    public function testMultiply(float $example1, float $example2, float $expected): void
    {
        // given
        $amount1 = new Amount($example1);
        $amount2 = new Amount($example2);

        // when
        $result = $amount1->multiply($amount2);

        // then
        self::assertEquals($expected, $result->getValue());
    }

    public function getExamples(): array
    {
        return [
            [1, 1.0],
            [1.0, 1.0],
            [1.1, 1.1],
            [3.141592653589793238462643383279502884197, 3.1415],
        ];
    }

    public function getExamplesWithImproperValues(): array
    {
        return [
            [0],
            [-100],
        ];
    }

    public function multiplyExamples(): array
    {
        return [
            [1, 1, 1],
            [2, 1, 2],
            [2, 2, 4],
            [2, 20, 40],
            [2, 3.3, 6.6],
            [3.141592653589793238462643383279502884197, 3.141592653589793238462643383279502884197, 9.8690],
        ];
    }
}
