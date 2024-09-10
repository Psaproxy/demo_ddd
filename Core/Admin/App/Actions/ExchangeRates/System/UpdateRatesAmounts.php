<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System;

use Core\Admin\App\Actions\ExchangeRates\System\Events\ExchangeRatesAmountsWasUpdated;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\IExchangeRateRepository;
use Core\Common\Infra\Event\EventsPublisher;
use Core\Common\Infra\ILogger;
use Core\Common\Infra\ITransaction;

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

    public function updateEnabled(): void
    {
        $rates = $this->repository->findEnabled();
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
                        "Не удалось получить новую сумму курса обмена валюты {$rate->currencyFromCode()} к {$rate->currencyToCode()}."
                    );
                    return;
                }

                $rate->updateAmount($newAmount->amount());

                $this->repository->updateAmount($rate);

                $this->eventsPublisher->publish(...$rate->releaseEvents());
            });
        }

        $this->eventsPublisher->publish(new ExchangeRatesAmountsWasUpdated());
    }
}
