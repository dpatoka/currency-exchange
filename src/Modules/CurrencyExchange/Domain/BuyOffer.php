<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

readonly class BuyOffer
{
    public function __construct(private Money $amountToBuy, private Currency $currencyToReturn)
    {
    }

    public function getAmountToBuy(): Money
    {
        return $this->amountToBuy;
    }

    public function getCurrencyToBuy(): Currency
    {
        return $this->amountToBuy->getCurrency();
    }

    public function getCurrencyToReturn(): Currency
    {
        return $this->currencyToReturn;
    }
}
