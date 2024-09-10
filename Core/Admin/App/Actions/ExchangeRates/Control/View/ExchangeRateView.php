<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control\View;

use Core\Common\DTO\CurrencyDTO;

readonly class ExchangeRateView
{
    public function __construct(
        public bool        $isEnabled,
        public CurrencyDTO $currencyFrom,
        public CurrencyDTO $currencyTo,
        public string      $amount,
        public string      $updatedAt,
        public string      $hint,
    )
    {
    }
}
