<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

readonly class BuyOffer
{
    public function __construct(private Money $moneyToBuy, private Currency $currencyToReturnForCustomer)
    {
    }

    public function getMoneyToBuy(): Money
    {
        return $this->moneyToBuy;
    }

    public function getCurrencyToBuy(): Currency
    {
        return $this->moneyToBuy->getCurrency();
    }

    public function getCurrencyToReturnForCustomer(): Currency
    {
        return $this->currencyToReturnForCustomer;
    }
}
