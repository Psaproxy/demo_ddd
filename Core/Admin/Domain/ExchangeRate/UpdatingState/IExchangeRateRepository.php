<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingState;

use Core\Admin\Domain\ExchangeRate\Exceptions\ExchangeRatesNotExistsException;

interface IExchangeRateRepository
{
    /**
     * @return ExchangeRate[]
     * @throws ExchangeRatesNotExistsException
     */
    public function getList(array $ids): array;

    public function updateState(ExchangeRate $rate): void;
}
