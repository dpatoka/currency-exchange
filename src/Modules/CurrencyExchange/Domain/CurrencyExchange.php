<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\BuildingBlocks\Domain\AggregateRoot;
use App\Modules\CurrencyExchange\Domain\Port\CurrencyExchangeRateProvider;
use App\Modules\CurrencyExchange\Domain\Port\FeeProvider;
use App\Modules\CurrencyExchange\Infrastructure\Adapter\HardcodedCurrencyExchangeRateProvider;
use App\Modules\CurrencyExchange\Infrastructure\Adapter\HardcodedFeeProvider;

class CurrencyExchange implements AggregateRoot
{
    public function buy(BuyOffer $offer, CurrencyExchangeRateProvider $exchangeRateProvider, FeeProvider $feeProvider): Money
    {
        $exchangeRate = $this->getExchangeRateForBuying($offer, $exchangeRateProvider);
        $fee = $feeProvider->getPercentage();
        $amountToBuy = $offer->getMoneyToBuy()->getAmount();

        $cost = $amountToBuy->multiply($exchangeRate->getAmount());
        $feeAmount = $cost->multiply($fee);
        $amountForClient = $cost->subtract($feeAmount);

        return Money::fromAmount($amountForClient, $offer->getCurrencyToReturnForCustomer());
    }

    public function sell(SellOffer $offer, HardcodedCurrencyExchangeRateProvider $exchangeRateProvider, HardcodedFeeProvider $feeProvider): Money
    {
        $exchangeRate = $this->getExchangeRateForSelling($offer, $exchangeRateProvider);
        $fee = $feeProvider->getPercentage();
        $amountToSell = $offer->getMoneyToSell()->getAmount();

        $baseValue = $amountToSell->divide($exchangeRate->getAmount());
        $feeAmount = $baseValue->multiply($fee);
        $finalPrice = $baseValue->add($feeAmount);

        return Money::fromAmount($finalPrice, $offer->getCurrencyToAcceptFromCustomer());
    }

    private function getExchangeRateForBuying(BuyOffer $offer, CurrencyExchangeRateProvider $exchangeRateProvider): CurrencyExchangeRate
    {
        $exchangeCurrencies = new ExchangedCurrencies($offer->getCurrencyToBuy(), $offer->getCurrencyToReturnForCustomer());

        return $exchangeRateProvider->getForCurrencies($exchangeCurrencies);
    }

    private function getExchangeRateForSelling(SellOffer $offer, CurrencyExchangeRateProvider $exchangeRateProvider): CurrencyExchangeRate
    {
        $exchangeCurrencies = new ExchangedCurrencies($offer->getCurrencyToAcceptFromCustomer(), $offer->getCurrencyToSell());

        return $exchangeRateProvider->getForCurrencies($exchangeCurrencies);
    }
}
