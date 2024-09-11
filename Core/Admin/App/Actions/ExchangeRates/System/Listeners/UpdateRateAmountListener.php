<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Listeners;

use Core\Admin\App\Actions\ExchangeRates\System\UpdateRatesAmounts;
use Core\Admin\Domain\ExchangeRate\Control\Events\ExchangeRateWasCreated;
use Core\Admin\Domain\ExchangeRate\UpdatingState\Events\ExchangeRateStateWasUpdated;
use Core\Common\Infra\Event\IEvent;
use Core\Common\Infra\Event\ListenerBase;

class UpdateRateAmountListener extends ListenerBase
{
    public function __construct(
        readonly private UpdateRatesAmounts $updateRatesAmounts
    )
    {
    }

    public function process(IEvent $event): void
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
