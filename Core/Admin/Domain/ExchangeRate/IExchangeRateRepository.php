<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate;

use Core\Common\VO\CurrencyCode;

interface IExchangeRateRepository
{
    public function add(ExchangeRateBase $rate): void;

    public function isExistsByCurrency(CurrencyCode $currencyFromCode, CurrencyCode $currencyToCode): bool;
}
