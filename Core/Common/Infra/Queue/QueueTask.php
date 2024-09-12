<?php

declare(strict_types=1);

namespace Core\Common\Infra\Queue;

use Core\Common\Exceptions\RuntimeException;

abstract class QueueTask implements IQueueTask
{
    readonly private QueueTaskID $taskId;
    private int $taskCountAttemptsWas = 0;
    private ?bool $taskIsProcessed = null;
    readonly private array $taskData;
    private array $taskDataConvected = [];
    readonly private \DateTimeImmutable $taskCreatedAt;

    public function __construct(array $taskData)
    {
        $this->taskId = new QueueTaskID();
        $this->taskData = $taskData;
        $this->taskCreatedAt = new \DateTimeImmutable();
    }

    /**
     * @throws \JsonException
     */
    public function queueData(string $publisherName): string
    {
        return \json_encode([
            'id'                 => $this->taskId,
            'count_attempts_was' => $this->taskCountAttemptsWas,
            'data'               => $this->taskData,
            'created_at'         => $this->taskCreatedAt->getTimestamp(),
            'publisher'          => $publisherName,
            'published_at'       => (new \DateTimeImmutable())->getTimestamp(),
        ], JSON_THROW_ON_ERROR);
    }

    public function taskId(): QueueTaskID
    {
        return $this->taskId;
    }

    public function taskCountAttemptsWas(): int
    {
        return $this->taskCountAttemptsWas;
    }

    public function isTaskAttemptAvailable(int $maxAttempts): bool
    {
        return $this->taskCountAttemptsWas <= $maxAttempts;
    }

    public function isTaskProcessed(): bool
    {
        return null !== $this->taskIsProcessed;
    }

    public function isTaskSuccess(): bool
    {
        return true === $this->taskIsProcessed;
    }

    public function isTaskFail(): bool
    {
        return false === $this->taskIsProcessed;
    }

    public function markTaskAsProcessed(bool $isSuccess): void
    {
        if (null !== $this->taskIsProcessed) {
            throw new RuntimeException(
                "Невозможно изменить состояние обработки задачи с ID \"$this->taskId\" на \"$isSuccess\". Так состояние уже был изменен на \"$this->taskIsProcessed\"."
            );
        }
        $this->taskIsProcessed = $isSuccess;
        $this->taskCountAttemptsWas++;
    }

    public function markTaskAsSuccess(): void
    {
        $this->markTaskAsProcessed(true);
    }

    public function markTaskAsFail(): void
    {
        $this->markTaskAsProcessed(false);
    }

    public function taskData(): array
    {
        return $this->taskData;
    }

    protected function getTaskValue(string $keyName, ?callable $convector = null): mixed
    {
        if ($convector && array_key_exists($keyName, $this->taskDataConvected)) {
            return $this->taskDataConvected[$keyName];
        }

        if (!array_key_exists($keyName, $this->taskData)) {
            throw new RuntimeException(
                "Не найдено значение с ключом \"$keyName\" в данных задачи: " . self::class
            );
        }
        $value = $this->taskData[$keyName];

        return !$convector ? $value : $this->taskDataConvected[$keyName] = $convector($value);
    }

    protected function findTaskValue(string $keyName, mixed $default = null, ?callable $convector = null): mixed
    {
        try {
            $value = $this->getTaskValue($keyName, $convector);
        } catch (\Throwable) {
            $value = $default;
        }
        return !$convector ? $value : $this->taskDataConvected[$keyName] = $convector($value);
    }

    protected function getTaskValue2(string $keyName): mixed
    {
        if (!array_key_exists($keyName, $this->taskData)) {
            throw new RuntimeException(
                "Не найдено значение с ключом \"$keyName\" в данных задачи: " . self::class
            );
        }

        return $this->taskData[$keyName];
    }

    protected function findTaskValue2(string $keyName): mixed
    {
        try {
            return $this->getTaskValue($keyName);
        } catch (\Throwable) {
            return null;
        }
    }

    public function taskCreatedAt(): \DateTimeImmutable
    {
        return $this->taskCreatedAt;
    }
}
