<?php

declare(strict_types=1);

use Core\Admin\App\Actions\ExchangeRates\System\Listeners\UpdateRateAmountListener;
use Core\Admin\Domain\ExchangeRate\Control\Events\ExchangeRateWasCreated;
use Core\Admin\Domain\ExchangeRate\UpdatingState\Events\ExchangeRateStateWasUpdated;

class EventsConfig implements \Core\Common\Infra\Event\IEventsConfig
{
    /**
     * @return array<string, string[]> Ключ - класс события. Значение - список классов слушателей.
     */
    public function listeners(): array
    {
        return [
            ExchangeRateWasCreated::class      => [
                UpdateRateAmountListener::class,
            ],
            ExchangeRateStateWasUpdated::class => [
                UpdateRateAmountListener::class,
            ],
        ];
    }
}
