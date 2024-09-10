<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate;

interface IExchangeRateRepository
{
    public function add(ExchangeRateBase $rate): void;
}
