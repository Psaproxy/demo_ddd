<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control\Exceptions;

use Core\Common\Domain\VO\CurrencyCode;
use Core\Common\Exceptions\RuntimeException;

class ExchangeRateAlreadyExistsException extends RuntimeException
{
    public function __construct(
        readonly private CurrencyCode $currencyFromCode,
        readonly private CurrencyCode $currencyToCode,
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
