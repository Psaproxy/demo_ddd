<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control\Exceptions;

use Core\Common\Exceptions\RuntimeException;
use Core\Common\VO\CurrencyCode;

class ExchangeRateAlreadyExistsException extends RuntimeException
{
    public function __construct(
        private readonly CurrencyCode $currencyFromCode,
        private readonly CurrencyCode $currencyToCode,
    )
    {
        parent::__construct(
            "Курс обмена валюты \"$currencyFromCode\" на \"$currencyToCode\" уже имеется.",
        );
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
