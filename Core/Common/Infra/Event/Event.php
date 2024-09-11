<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

abstract class Event implements IEvent
{
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
