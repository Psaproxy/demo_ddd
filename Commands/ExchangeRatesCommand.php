<?php
/**
 * @noinspection PhpUnused
 * @noinspection UnknownInspectionInspection
 */

declare(strict_types=1);

namespace Commands;

use Core\Admin\App\Actions\ExchangeRates\System\Actions\UpdateRatesAmounts;

/**
 *  Команду необходимо запускать регулярно,
 */
readonly class ExchangeRatesCommand
{
    public function __construct(
        private UpdateRatesAmounts $updateRatesAmounts,
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
}
