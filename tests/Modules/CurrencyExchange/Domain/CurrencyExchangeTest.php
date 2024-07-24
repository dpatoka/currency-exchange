<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\BuyOffer;
use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\CurrencyExchange;
use App\Modules\CurrencyExchange\Domain\Money;
use App\Modules\CurrencyExchange\Infrastructure\Adapter\HardcodedCurrencyExchangeRateProvider;
use App\Modules\CurrencyExchange\Infrastructure\Adapter\HardcodedFeeProvider;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeTest extends TestCase
{
    private HardcodedCurrencyExchangeRateProvider $currencyExchangeRateProvider;
    private HardcodedFeeProvider $feeProvider;

    public function setUp(): void
    {
        $this->currencyExchangeRateProvider = new HardcodedCurrencyExchangeRateProvider();
        $this->feeProvider = new HardcodedFeeProvider();

        parent::setUp();
    }

    /**
     * @dataProvider getBuyExamples
     */
    public function testBuy(BuyOffer $offer, Money $expected): void
    {
        // given
        $currencyExchange = new CurrencyExchange();

        // when
        $result = $currencyExchange->buy(
            $offer,
            $this->currencyExchangeRateProvider,
            $this->feeProvider
        );

        // then
        self::assertTrue($expected->equals($result));
    }

    public function getBuyExamples(): array
    {
        return [
            'The customer sells EUR 100 for GBP' => [
                'offer' => new BuyOffer(
                    Money::from(100, Currency::EUR),
                    Currency::GBP
                ),
                'expected' => Money::from(15678000, Currency::GBP),
            ],
            'The customer sells GBP 100 for EUR' => [
                'offer' => new BuyOffer(
                    Money::from(100, Currency::GBP),
                    Currency::EUR
                ),
                'expected' => Money::from(15432000, Currency::EUR),
            ],
        ];
    }
}
