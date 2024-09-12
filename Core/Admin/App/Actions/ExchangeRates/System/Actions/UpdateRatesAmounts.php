<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Actions;

use Core\Admin\App\Actions\ExchangeRates\System\Exceptions\ExchangeRateAmountUpdatingException;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\IExchangeRateRepository;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\IEventsPublisher;
use Core\Common\Infra\ITransaction;

readonly class UpdateRatesAmounts
{
    public function __construct(
        private ITransaction            $transaction,
        private IEventsPublisher        $eventsPublisher,
        private IExchangeRateRepository $repository,
    )
    {
    }

    public function addAllEnabledToUpdating(bool $notUpdatedToday = false): void
    {
        $ratesIds = $this->repository->findIdsEnabled($notUpdatedToday);
        if (!$ratesIds) return;

        $this->repository->addOnAmountsUpdating(...$ratesIds);
    }

    public function processUpdating(): void
    {
        $this->repository->processAmountsUpdating(function (ExchangeRateID $rateId): void {
            $this->transaction->execute(function () use ($rateId) {
                foreach ($this->update($rateId) as $error) throw $error;
            });
        });
    }

    /**
     * Будут обработаны все ID. Итератор возвращает только ошибки.
     */
    private function update(ExchangeRateID ...$ratesIds): \Iterator
    {
        $rates = $this->repository->getList(...$ratesIds);
        if (!$rates) return;

        $newAmounts = $this->repository->findNewAmounts(...$rates);

        $newAmounts_ = [];
        foreach ($newAmounts as $newAmount) {
            $newAmounts_["{$newAmount->currencyFromCode()}-{$newAmount->currencyToCode()}"] = $newAmount;
        }
        $newAmounts = $newAmounts_;

        foreach ($rates as $rate) {
            $newAmount = $newAmounts["{$rate->currencyFromCode()}-{$rate->currencyToCode()}"];
            if ($newAmount === null) {
                yield new ExchangeRateAmountUpdatingException(
                    $rate->id(),
                    "Не удалось получить новую сумму курса обмена валюты {$rate->currencyFromCode()} на {$rate->currencyToCode()}."
                );
                continue;
            }

            $isAmountUpdated = $rate->updateAmount($newAmount->amount());
            if (!$isAmountUpdated) continue;

            $this->repository->updateAmount($rate);

            $this->eventsPublisher->publish(...$rate->releaseEvents());
        }
    }
}
