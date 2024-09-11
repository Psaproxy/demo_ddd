<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

interface IEvent
{
    public function createdAt(): \DateTimeImmutable;
}
