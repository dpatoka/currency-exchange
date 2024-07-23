<?php
declare(strict_types=1);

namespace App\Modules\CurrencyExchange\Domain\Exception;

class InvalidAmountException extends CurrencyExchangeException
{
    public static function fromAmount(int $amount): self
    {
        return new self(
            sprintf('Value %d is not allowed as it is smaller than 1', $amount)
        );
    }
}