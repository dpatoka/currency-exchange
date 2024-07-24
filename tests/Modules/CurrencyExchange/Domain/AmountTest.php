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
}
