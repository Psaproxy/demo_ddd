<?php

declare(strict_types=1);

namespace Core\Common\App\Queue;

interface IQueueHandler
{
    public function handle(): void;
}
