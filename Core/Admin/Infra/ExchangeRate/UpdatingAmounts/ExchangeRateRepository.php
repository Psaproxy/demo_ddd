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

class ExchangeRateRepository implements IExchangeRateRepository
{
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
     * @throws \Throwable
     */
    public function processAmountsUpdating(callable $handler): void
    {
        /** @var AmountsUpdatingTask $task */
        $task = $this->queue->findNext('queue_name', AmountsUpdatingTask::class);
        if (!$task) return;

        //todo Реализовать опциональное значение макс попыток в задаче.
        //todo Реализовать опциональное авто отклонение при исчерпании попыток.
        //todo Перенести вызов исключение в класс задачи.
        //todo Перенести значение макс попыток в конфиг.
        if ($task->isAttemptAvailable(10)) {
            $this->queue->fail($task);
            //todo Добавить общее исключение завершения ошибок обработки.
            throw new \RuntimeException(
                "Не удалось обновить сумму курса обмена с ID \"{$task->exchangeRateID()}\". Исчерпаны попытки обработать задачу из очереди с ID \"{$task->taskId()}\". Было попыток: {$task->attempt()}."
            );
        }

        try {
            $handler($task->exchangeRateID());
            $this->queue->success($task);

        } catch (\Throwable $exception) {
            //todo Реализовать метод с авто-повтором на основе доступных попыток.
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
