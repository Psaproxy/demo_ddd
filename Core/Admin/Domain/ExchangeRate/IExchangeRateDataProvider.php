<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate;

use Core\Admin\Domain\ExchangeRate\DTO\ExchangeRateDTO;

interface IExchangeRateDataProvider
{
    /**
     * @return ExchangeRateDTO[]
     */
    public function findListForControl(): array;
}
