<?php

declare(strict_types=1);

class EventsConfig implements \Core\Common\Infra\Event\IEventsConfig
{
    /**
     * @return array<string, string[]> Ключ - класс события. Значение - список классов слушателей.
     */
    public function listeners(): array
    {
        return [
            //Event::class      => [
            //    Listener1::class,
            //    Listener2::class,
            //],
        ];
    }
}
