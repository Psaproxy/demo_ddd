<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts\VO;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateAmount;
use Core\Common\Domain\VO\CurrencyCode;

readonly class NewAmount
{
    public function __construct(
        private ExchangeRateAmount $amount,
        private CurrencyCode       $currencyFromCode,
        private CurrencyCode       $currencyToCode,
    )
    {
    }

    public function amount(): ExchangeRateAmount
    {
        return $this->amount;
    }

    public function currencyFromCode(): CurrencyCode
    {
        return $this->currencyFromCode;
    }

    public function currencyToCode(): CurrencyCode
    {
        return $this->currencyToCode;
    }
}
