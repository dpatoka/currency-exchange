<?php

namespace App\Tests\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\BuyOffer;
use App\Modules\CurrencyExchange\Domain\Currency;
use App\Modules\CurrencyExchange\Domain\CurrencyExchange;
use App\Modules\CurrencyExchange\Domain\Money;
use App\Modules\CurrencyExchange\Domain\SellOffer;
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
        self::assertTrue(
            $expected->equals($result),
            sprintf('Expected %f, actual %f', $expected->getAmount()->getValue(), $result->getAmount()->getValue())
        );
    }

    /**
     * @dataProvider getSellExamples
     */
    public function testSell(SellOffer $offer, Money $expected): void
    {
        // given
        $currencyExchange = new CurrencyExchange();

        // when
        $result = $currencyExchange->sell(
            $offer,
            $this->currencyExchangeRateProvider,
            $this->feeProvider
        );

        // then
        self::assertTrue(
            $expected->equals($result),
            sprintf('Expected %f, actual %f', $expected->getAmount()->getValue(), $result->getAmount()->getValue())
        );
    }

    public function getBuyExamples(): array
    {
        return [
            'The customer sells EUR 100 for GBP' => [
                'offer' => new BuyOffer(
                    Money::fromFloat(100, Currency::EUR),
                    Currency::GBP
                ),
                'expected' => Money::fromFloat(155.21220, Currency::GBP),
            ],
            'The customer sells GBP 100 for EUR' => [
                'offer' => new BuyOffer(
                    Money::fromFloat(100, Currency::GBP),
                    Currency::EUR
                ),
                'expected' => Money::fromFloat(152.77680, Currency::EUR),
            ],
        ];
    }

    public function getSellExamples(): array
    {
        return [
            'The customer buys 100 GBP for EUR' => [
                'offer' => new SellOffer(
                    Money::fromFloat(100, Currency::GBP),
                    Currency::EUR
                ),
                'expected' => Money::fromFloat(64.421481, Currency::EUR),
            ],
            'The customer buys 100 EUR for GBP' => [
                'offer' => new SellOffer(
                    Money::fromFloat(100, Currency::EUR),
                    Currency::GBP
                ),
                'expected' => Money::fromFloat(65.44841, Currency::GBP),
            ],
        ];
    }
}
