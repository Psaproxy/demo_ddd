<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Control;

use Core\Admin\Domain\ExchangeRate\Control\DTO\ExchangeRateDTO;

interface IExchangeRateDataProvider
{
    /**
     * @return ExchangeRateDTO[]
     */
    public function findList(): array;
}
