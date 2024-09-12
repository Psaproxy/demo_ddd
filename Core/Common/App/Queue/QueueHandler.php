<?php

declare(strict_types=1);

namespace Core\Common\App\Queue;

use Core\Common\Infra\ILogger;

abstract class QueueHandler implements IQueueHandler
{
    public function __construct(
        readonly protected ILogger $logger,
    )
    {
    }

    public function handle(): void
    {
        try {
            while (true) {
                $this->iteration();
                usleep(10);
            }
        } catch (\Throwable $exception) {
            $this->logger->error($exception);
        }
    }

    abstract protected function iteration(): void;
}
