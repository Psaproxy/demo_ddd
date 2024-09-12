<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

use Core\Common\Event\IEvent;

interface IEventsPublisher
{
    public function publish(IEvent ...$events): void;
}
