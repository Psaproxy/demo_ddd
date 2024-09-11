<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingState;

use Core\Admin\Domain\ExchangeRate\Exceptions\ExchangeRatesNotFoundException;

interface IExchangeRateRepository
{
    /**
     * @return ExchangeRate[]
     * @throws ExchangeRatesNotFoundException
     */
    public function getList(array $ids): array;

    public function updateState(ExchangeRate $rate): void;
}
