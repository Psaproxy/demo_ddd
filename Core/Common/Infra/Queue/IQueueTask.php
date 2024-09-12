<?php

declare(strict_types=1);

namespace Core\Common\Infra\Queue;

/**
 * todo Добавить счетчик количества попыток.
 */
interface IQueueTask
{
    public function taskId(): QueueTaskID;

    public function attempt(): int;

    public function taskData(): mixed;

    public function taskCreatedAt(): \DateTimeImmutable;
}
