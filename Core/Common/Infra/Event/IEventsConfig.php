<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

interface IEventsConfig
{
    /**
     * @return array<string, string[]> Ключ - класс события. Значение - список классов слушателей.
     */
    public function listeners(): array;
}
