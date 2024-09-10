<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

trait Events
{
    /**
     * @var Event[]
     */
    private array $events = [];

    private function addEvents(Event ...$events): void
    {
        foreach ($events as $event) {
            $this->events[] = $event;
        }
    }

    /**
     * @return Event[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
