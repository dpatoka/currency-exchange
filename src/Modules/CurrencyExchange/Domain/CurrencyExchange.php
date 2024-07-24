<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

use App\Modules\CurrencyExchange\Domain\Port\CurrencyExchangeRateProvider;
use App\Modules\CurrencyExchange\Domain\Port\FeeProvider;

class CurrencyExchange
{
    public function buy(BuyOffer $offer, CurrencyExchangeRateProvider $exchangeRateProvider, FeeProvider $feeProvider): Money
    {
        $exchangeRate = $this->getExchangeRate($offer, $exchangeRateProvider);
        $fee = $feeProvider->getPercentage();

        $cost = $offer->getAmountToBuy()->getAmount()->multiply($exchangeRate->getAmount());
        $feeAmount = $cost->multiply($fee);
        $amountForClient = $cost->subtract($feeAmount);

        return Money::fromAmount($amountForClient, $offer->getCurrencyToReturn());
    }

    private function getExchangeRate(BuyOffer $offer, CurrencyExchangeRateProvider $exchangeRateProvider): CurrencyExchangeRate
    {
        $exchangeCurrencies = new ExchangedCurrencies($offer->getCurrencyToBuy(), $offer->getCurrencyToReturn());

        return $exchangeRateProvider->getForCurrencies($exchangeCurrencies);
    }
}
