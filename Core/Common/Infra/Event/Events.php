<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

trait Events
{
    /**
     * @var IEvent[]
     */
    private array $events = [];

    private function addEvents(IEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->events[] = $event;
        }
    }

    /**
     * @return IEvent[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
