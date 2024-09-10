<?php
/**
 * @noinspection PhpUnused
 * @noinspection UnknownInspectionInspection
 */

declare(strict_types=1);

namespace Commands;

use Core\Admin\App\Actions\ExchangeRates\System\UpdateRatesAmounts;

readonly class ExchangeRatesCommand
{
    public function __construct(
        private UpdateRatesAmounts $updateRatesAmounts,
    )
    {
    }

    public function updateAmountsForEnabled(): void
    {
        $this->updateRatesAmounts->updateEnabled();
    }
}
