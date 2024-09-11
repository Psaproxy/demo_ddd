<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System;

use Core\Admin\App\Actions\ExchangeRates\System\Events\ExchangeRatesAmountsWasUpdated;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\ExchangeRate;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\IExchangeRateRepository;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\EventsPublisher;
use Core\Common\Infra\ILogger;
use Core\Common\Infra\ITransaction;

/**
 * todo Доделать опциональное обновление через очередь, не мгновенно.
 */
readonly class UpdateRatesAmounts
{
    public function __construct(
        private ITransaction            $transaction,
        private ILogger                 $logger,
        private EventsPublisher         $eventsPublisher,
        private IExchangeRateRepository $repository,
    )
    {
    }

    public function updateListEnabled(): void
    {
        $rates = $this->repository->findEnabled();
        if (!$rates) return;

        $this->updateList(...$rates);

        $this->eventsPublisher->publish(new ExchangeRatesAmountsWasUpdated());
    }

    public function update(ExchangeRateID $rateID): void
    {
        $this->updateList(
            $this->repository->get($rateID)
        );
    }

    private function updateList(ExchangeRate ...$rates): void
    {
        if (!$rates) return;

        $newAmounts = $this->repository->findNewAmounts(...$rates);

        $newAmounts_ = [];
        foreach ($newAmounts as $newAmount) {
            $newAmounts_["{$newAmount->currencyFromCode()}-{$newAmount->currencyToCode()}"] = $newAmount;
        }
        $newAmounts = $newAmounts_;

        foreach ($rates as $rate) {
            $this->transaction->execute(function () use ($rate, $newAmounts) {
                $newAmount = $newAmounts["{$rate->currencyFromCode()}-{$rate->currencyToCode()}"];
                if ($newAmount === null) {
                    $this->logger->warning(
                        "Не удалось получить новую сумму курса обмена валюты {$rate->currencyFromCode()} на {$rate->currencyToCode()}."
                    );
                    return;
                }

                $isAmountUpdated = $rate->updateAmount($newAmount->amount());
                if (!$isAmountUpdated) return;

                $this->repository->updateAmount($rate);

                $this->eventsPublisher->publish(...$rate->releaseEvents());
            });
        }
    }
}
