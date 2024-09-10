<?php
/**
 * @noinspection PhpUnused
 * @noinspection UnknownInspectionInspection
 */

declare(strict_types=1);

namespace Commands\Admin\Control;

use Core\Admin\App\Actions\ExchangeRates\System\UpdateRatesAmounts;

readonly class ExchangeRatesCommand
{
    public function __construct(
        private UpdateRatesAmounts $updateRatesAmounts,
    )
    {
    }

    public function updateEnabledRatesAmounts(): void
    {
        $this->updateRatesAmounts->updateEnabled();
    }
}
