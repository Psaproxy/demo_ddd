<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Listeners;

use Core\Admin\App\Actions\ExchangeRates\System\UpdateRatesAmounts;
use Core\Admin\Domain\ExchangeRate\Control\Events\ExchangeRateWasCreated;
use Core\Admin\Domain\ExchangeRate\UpdatingState\Events\ExchangeRateStateWasUpdated;
use Core\Common\Infra\Event\Event;
use Core\Common\Infra\Event\IListener;

readonly class UpdateRateAmountListener implements IListener
{
    public function __construct(
        private UpdateRatesAmounts $updateRatesAmounts
    )
    {
    }

    public function process(Event $event): void
    {
        if ((
                !($event instanceof ExchangeRateWasCreated)
                && !($event instanceof ExchangeRateStateWasUpdated)
            )
            || ($event instanceof ExchangeRateStateWasUpdated && !$event->newState())
        ) return;

        $this->updateRatesAmounts->update($event->id());
    }
}
