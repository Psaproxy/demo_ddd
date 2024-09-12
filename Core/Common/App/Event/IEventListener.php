<?php

declare(strict_types=1);

namespace Core\Common\App\Event;

use Core\Common\Event\IEvent;

interface IEventListener
{
    public function handle(IEvent $event): void;
}
