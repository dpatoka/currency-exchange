<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Amount;
use App\Modules\CurrencyExchange\Domain\Exception\InvalidAmountException;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    /**
     * @dataProvider getCreationFloatExamples
     */
    public function testCreation(float $example, float $expected): void
    {
        // when
        $result = new Amount($example);

        // then
        self::assertEquals($expected, $result->getValue());
    }

    /**
     * @dataProvider getCreationWithImproperValuesExamples
     */
    public function testCreationWithImProperValues(float $example): void
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

    /**
     * @dataProvider subtractExamples
     */
    public function testSubtract(float $example1, float $example2, float $expected): void
    {
        // given
        $amount1 = new Amount($example1);
        $amount2 = new Amount($example2);

        // when
        $result = $amount1->subtract($amount2);

        // then
        self::assertEquals($expected, $result->getValue());
    }

    /**
     * @dataProvider addExamples
     */
    public function testAdd(float $example1, float $example2, float $expected): void
    {
        // given
        $amount1 = new Amount($example1);
        $amount2 = new Amount($example2);

        // when
        $result = $amount1->add($amount2);

        // then
        self::assertEquals($expected, $result->getValue());
    }

    /**
     * @dataProvider divideExamples
     */
    public function testDivide(float $example1, float $example2, float $expected): void
    {
        // given
        $amount1 = new Amount($example1);
        $amount2 = new Amount($example2);

        // when
        $result = $amount1->divide($amount2);

        // then
        self::assertEquals($expected, $result->getValue());
    }

    public function getCreationFloatExamples(): array
    {
        return [
            [1, 1.0],
            [1.0, 1.0],
            [1.1, 1.1],
            [3.141592653589793238462643383279502884197, 3.14159],
        ];
    }

    public function getCreationWithImproperValuesExamples(): array
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
            [1, 0.01, 0.01],
            [2, 3.3, 6.6],
            [3.141592653589793238462643383279502884197, 3.141592653589793238462643383279502884197, 9.86958],
        ];
    }

    public function subtractExamples(): array
    {
        return [
            [2, 1, 1],
            [20, 1.1, 18.89999],
        ];
    }

    public function divideExamples(): array
    {
        return [
            [1, 1, 1],
            [2, 1, 2],
            [6, 3, 2],
            [1, 2, 0.5],
            [9.86958, 3.141592653589793238462643383279502884197, 3.14158],
        ];
    }

    public function addExamples(): array
    {
        return [
            [1, 1, 2],
            [0.1, 1, 1.1],
            [3.141592653589793238462643383279502884197, 3.141592653589793238462643383279502884197, 6.28318],
        ];
    }
}
