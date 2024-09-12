<?php

declare(strict_types=1);

namespace Core\Admin\Infra\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\Exceptions\ExchangeRatesNotFoundException;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\ExchangeRate;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\IExchangeRateRepository;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\VO\NewAmount;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Admin\Infra\ExchangeRate\UpdatingAmounts\VO\AmountsUpdatingTask;
use Core\Common\Exceptions\NotImplementedException;
use Core\Common\Infra\Queue\Exceptions\QueueTaskAttemptLimitException;
use ExchangeRatesConfig;

readonly class ExchangeRateRepository implements IExchangeRateRepository
{
    public function __construct(
        private ExchangeRatesConfig $config,
    )
    {
    }

    /**
     * @return ExchangeRateID[]
     */
    public function findIdsEnabled(bool $notUpdatedToday = false): array
    {
        throw new NotImplementedException();
    }

    public function addOnAmountsUpdating(ExchangeRateID ...$ratesIds): void
    {
        $tasks = array_map(static function (ExchangeRateID $rateID): AmountsUpdatingTask {
            return new AmountsUpdatingTask($rateID);
        }, $ratesIds);

        /** @noinspection PhpUndefinedFieldInspection */
        $this->queue->add('queue_name', ...$tasks);
    }

    /**
     * @param callable(ExchangeRateID $rateId): void $handler
     * @noinspection PhpUndefinedFieldInspection
     * @throws QueueTaskAttemptLimitException|\Throwable
     */
    public function processAmountsUpdating(callable $handler): void
    {
        /** @var AmountsUpdatingTask $task */
        $task = $this->queue->findNext('queue_name', AmountsUpdatingTask::class);
        if (!$task) return;

        if (!$task->isTaskAttemptAvailable($this->config->maxAttemptsOfAmountUpdating())) {
            $this->queue->fail($task);
            throw new QueueTaskAttemptLimitException(
                $task,
                "Не удалось обновить сумму курса обмена с ID \"{$task->exchangeRateID()}\"."
            );
        }

        try {
            $handler($task->exchangeRateID());
            $this->queue->success($task);

        } catch (\Throwable $exception) {
            $this->queue->failAndRepeat($task);
            throw $exception;
        }
    }

    /**
     * @return ExchangeRate[]
     * @throws ExchangeRatesNotFoundException
     */
    public function getList(ExchangeRateID ...$ids): array
    {
        throw new NotImplementedException();
    }

    /**
     * @return NewAmount[]
     */
    public function findNewAmounts(ExchangeRate ...$rates): array
    {
        throw new NotImplementedException();
    }

    public function updateAmount(ExchangeRate $rate): void
    {
        throw new NotImplementedException();
    }
}
