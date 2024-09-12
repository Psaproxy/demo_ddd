<?php
/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Commands;

use Core\Admin\App\Actions\ExchangeRates\System\Actions\UpdateRatesAmounts;
use Core\Admin\App\Actions\ExchangeRates\System\Actions\UpdateRatesAmountsHandler;

readonly class ExchangeRatesCommand
{
    public function __construct(
        private UpdateRatesAmounts        $updateRatesAmounts,
        private UpdateRatesAmountsHandler $updateRatesAmountsHandler,
    )
    {
    }

    public function addEnabledToUpdatingAmounts(): void
    {
        //$onlyNotUpdatedToday = $this->param('only_not_updated_today', true);
        $onlyNotUpdatedToday = true;

        /** @noinspection PhpConditionAlreadyCheckedInspection */
        $this->updateRatesAmounts->addAllEnabledToUpdating($onlyNotUpdatedToday);
    }

    public function runUpdateRatesAmountsHandler(): void
    {
        $this->updateRatesAmountsHandler->handle();
    }
}
