<?php

declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain;

readonly class SellOffer
{
    public function __construct(private Money $moneyToSell, private Currency $currencyToAcceptFromCustomer)
    {
    }

    public function getMoneyToSell(): Money
    {
        return $this->moneyToSell;
    }

    public function getCurrencyToSell(): Currency
    {
        return $this->moneyToSell->getCurrency();
    }

    public function getCurrencyToAcceptFromCustomer(): Currency
    {
        return $this->currencyToAcceptFromCustomer;
    }
}
