<?php

declare(strict_types=1);

namespace Core\Common\Infra\Queue;

interface IQueueHandler
{
    public function process(): void;
}
