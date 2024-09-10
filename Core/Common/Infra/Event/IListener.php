<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

interface IListener
{
    public function process(Event $event): void;
}
