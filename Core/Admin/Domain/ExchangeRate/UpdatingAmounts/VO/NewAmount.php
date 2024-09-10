<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts\VO;

use Core\Admin\Domain\ExchangeRate\VO\Amount;
use Core\Common\VO\CurrencyCode;

readonly class NewAmount
{
    public function __construct(
        private Amount       $amount,
        private CurrencyCode $currencyFromCode,
        private CurrencyCode $currencyToCode,
    )
    {
    }

    public function amount(): Amount
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
