<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control\View;

use Core\Common\View\DTO\CurrencyView;

readonly class ExchangeRateView
{
    public function __construct(
        public bool         $isEnabled,
        public CurrencyView $currencyFrom,
        public CurrencyView $currencyTo,
        public string       $amount,
        public string       $updatedAt,
        public string       $hint,
    )
    {
    }
}
