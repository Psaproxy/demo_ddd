<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\VO\NewAmount;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Exceptions\EntityNotFoundException;

interface IExchangeRateRepository
{
    /**
     * @throws EntityNotFoundException
     */
    public function get(ExchangeRateID $id): ExchangeRate;

    public function findEnabled(): array;

    /**
     * @return NewAmount[]
     */
    public function findNewAmounts(ExchangeRate ...$rates): array;

    public function updateAmount(ExchangeRate $rate): void;
}
