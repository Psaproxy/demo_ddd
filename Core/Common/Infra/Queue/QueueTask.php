<?php

declare(strict_types=1);

namespace Core\Common\Infra\Queue;

use Core\Common\Exceptions\RuntimeException;

abstract class QueueTask implements IQueueTask
{
    readonly private QueueTaskID $id;
    readonly private \DateTimeImmutable $createdAt;
    private ?bool $taskStatus = null;

    public function __construct(
        readonly private array $data,
    )
    {
        $this->id = new QueueTaskID();
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @throws \JsonException
     */
    public function __toString(): string
    {
        return \json_encode([
            'id'         => $this->id,
            'data'       => $this->data,
            'created_at' => $this->createdAt->getTimestamp(),
        ], JSON_THROW_ON_ERROR);
    }

    public function taskId(): QueueTaskID
    {
        return $this->id;
    }

    public function taskData(): array
    {
        return $this->data;
    }

    protected function getValue(string $keyName): mixed
    {
        if (!array_key_exists($keyName, $this->data)) {
            throw new RuntimeException(
                "Не найдено значение с ключом \"$keyName\" в данных задачи: " . self::class
            );
        }

        return $this->data[$keyName];
    }

    protected function findValue(string $keyName): mixed
    {
        try {
            return $this->getValue($keyName);
        } catch (\Exception) {
            return null;
        }
    }

    public function taskCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isTaskReady(): bool
    {
        return null !== $this->taskStatus;
    }

    public function isTaskSuccess(): bool
    {
        return true === $this->taskStatus;
    }

    public function isTaskFail(): bool
    {
        return false === $this->taskStatus;
    }

    public function changeTaskStatus(bool $value): void
    {
        if (null !== $this->taskStatus) {
            throw new RuntimeException(
                "Невозможно изменить статус задачи с ID \"$this->id\" на \"$value\". Так статус уже был изменен на \"$this->taskStatus\"."
            );
        }
        $this->taskStatus = $value;
    }

    public function markTaskAsSuccess(): void
    {
        $this->changeTaskStatus(true);
    }

    public function markTaskAsFail(): void
    {
        $this->changeTaskStatus(false);
    }
}
