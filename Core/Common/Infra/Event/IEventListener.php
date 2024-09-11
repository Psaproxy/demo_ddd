<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

interface IEventListener
{
    public function process(IEvent $event): void;
}
