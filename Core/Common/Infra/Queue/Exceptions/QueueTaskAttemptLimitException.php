<?php

declare(strict_types=1);

namespace Core\Common\Infra\Queue\Exceptions;

use Core\Common\Exceptions\LogicException;
use Core\Common\Infra\Queue\IQueueTask;

class QueueTaskAttemptLimitException extends LogicException
{
    public function __construct(
        readonly IQueueTask $task,
        string              $subMessage = "",
        int                 $code = 500,
        ?\Throwable         $previous = null
    )
    {
        parent::__construct(
            trim("Исчерпаны попытки обработать задачу из очереди с ID \"{$task->taskId()}\". Было сделано попыток: {$task->taskCountAttemptsWas()}. " . $subMessage),
            $code,
            $previous
        );
    }

    public function task(): IQueueTask
    {
        return $this->task;
    }
}
