<?php

namespace Core\Admin\App\Actions\Control\ExchangeRates\Exceptions;

use Core\Common\VO\CurrencyCode;

class ExchangeRateAlreadyExistsException extends \RuntimeException
{
    public function __construct(
        CurrencyCode $currencyFromCode,
        CurrencyCode $currencyToCode,
        int          $code = 0,
        ?\Throwable  $previous = null
    )
    {
        parent::__construct(
            "Курс обмена валют для \"$currencyFromCode\" к \"$currencyToCode\" уже имеется.",
            $code,
            $previous
        );
    }
}
