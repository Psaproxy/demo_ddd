<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control;

use Core\Admin\Domain\ExchangeRate\Exceptions\ExchangeRatesNotFoundException;
use Core\Admin\Domain\ExchangeRate\UpdatingState\IExchangeRateRepository;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\EventsPublisher;
use Core\Common\Infra\ITransaction;

readonly class UpdateStates
{
    public function __construct(
        private ITransaction            $transaction,
        private EventsPublisher         $eventsPublisher,
        private IExchangeRateRepository $repository,
    )
    {
    }

    /**
     * @param array<string, bool> $newStates Ключ - ID курса. Значение - новое состояние.
     * @throws ExchangeRatesNotFoundException
     */
    public function update(array $newStates): void
    {
        $ids = array_map(static function (string $id): ExchangeRateID {
            return new ExchangeRateID($id);
        }, array_keys($newStates));

        $rates = $this->repository->getList(...$ids);

        foreach ($rates as $rate) {
            $isStateUpdated = $rate->updateState($newStates[$rate->id()->value()]);
            if (!$isStateUpdated) continue;

            $this->transaction->execute(function () use ($rate) {
                $this->repository->updateState($rate);

                $this->eventsPublisher->publish(...$rate->releaseEvents());
            });
        }

    }
}
