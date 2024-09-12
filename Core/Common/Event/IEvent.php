<?php

declare(strict_types=1);

namespace Core\Common\Event;

interface IEvent
{
    public function createdAt(): \DateTimeImmutable;
}
