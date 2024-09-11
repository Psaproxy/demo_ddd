<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Actions;

use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\IExchangeRateRepository;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\EventsPublisher;
use Core\Common\Infra\ILogger;
use Core\Common\Infra\ITransaction;
use Random\RandomException;

class UpdateRatesAmounts
{
    public function __construct(
        readonly private ITransaction            $transaction,
        readonly private ILogger                 $logger,
        readonly private EventsPublisher         $eventsPublisher,
        readonly private IExchangeRateRepository $repository,
    )
    {
    }

    public function addAllEnabledToUpdating(bool $notUpdatedToday = false): void
    {
        $ratesIds = $this->repository->findIdsEnabled($notUpdatedToday);
        if (!$ratesIds) return;

        $this->repository->addTasksOnAmountsUpdating(...$ratesIds);
    }

    /**
     * @throws RandomException
     */
    public function processUpdating(): void
    {
        //todo Добавить значение размера пакта в конфиг.
        $tasks = $this->repository->findTasksOnAmountsUpdating(20);
        if (!$tasks) return;

        foreach ($tasks as $task) {
            $this->transaction->execute(function () use ($task) {
                $isUpdatingSuccess = $this->updateList($task->exchangeRateID());
                $task->changeTaskStatus($isUpdatingSuccess);
                $this->repository->updateTasksOnAmountsUpdating($task);
            });
        }
    }

    private function updateList(ExchangeRateID ...$ratesIds): bool
    {
        $rates = $this->repository->getList(...$ratesIds);
        if (!$rates) return true;

        $newAmounts = $this->repository->findNewAmounts(...$rates);

        $newAmounts_ = [];
        foreach ($newAmounts as $newAmount) {
            $newAmounts_["{$newAmount->currencyFromCode()}-{$newAmount->currencyToCode()}"] = $newAmount;
        }
        $newAmounts = $newAmounts_;

        $isAllSuccess = true;
        foreach ($rates as $rate) {
            $newAmount = $newAmounts["{$rate->currencyFromCode()}-{$rate->currencyToCode()}"];
            if ($newAmount === null) {
                $this->logger->warning(
                    "Не удалось получить новую сумму курса обмена валюты {$rate->currencyFromCode()} на {$rate->currencyToCode()}."
                );
                $isAllSuccess = false;
                continue;
            }

            $isAmountUpdated = $rate->updateAmount($newAmount->amount());
            if (!$isAmountUpdated) continue;

            $this->repository->updateAmount($rate);

            $this->eventsPublisher->publish(...$rate->releaseEvents());
        }

        return $isAllSuccess;
    }
}
