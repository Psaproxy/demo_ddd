<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\Exceptions\ExchangeRatesNotFoundException;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\VO\NewAmount;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;

interface IExchangeRateRepository
{
    /**
     * @return ExchangeRateID[]
     */
    public function findIdsEnabled(bool $notUpdatedToday = false): array;

    public function addOnUpdatingAmounts(ExchangeRateID ...$ratesIds): void;

    /**
     * @param callable(ExchangeRateID $rateId): void $handler
     */
    public function processUpdatingAmounts(callable $handler): void;

    /**
     * @return ExchangeRate[]
     * @throws ExchangeRatesNotFoundException
     */
    public function getList(ExchangeRateID ...$ids): array;

    /**
     * @return NewAmount[]
     */
    public function findNewAmounts(ExchangeRate ...$rates): array;

    public function updateAmount(ExchangeRate $rate): void;
}
