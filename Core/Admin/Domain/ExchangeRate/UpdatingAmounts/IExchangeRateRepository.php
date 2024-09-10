<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\VO\NewAmount;

interface IExchangeRateRepository
{
    /**
     * @return ExchangeRate[]
     */
    public function findEnabled(): array;

    /**
     * @return NewAmount[]
     */
    public function findNewAmounts(ExchangeRate ...$rates): array;

    public function updateAmount(ExchangeRate $rate): void;
}
