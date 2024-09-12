<?php

declare(strict_types=1);

namespace Core\Common\Infra\Event;

use Core\Common\App\Event\IEventListener;
use Core\Common\Event\IEvent;
use Core\Common\Infra\IDIContainer;

class EventsPublisher implements IEventsPublisher
{
    /**
     * @var array<string, IEventListener> Ключ - класс слушателя. Значение - экземпляр слушателя.
     */
    private array $listeners = [];

    public function __construct(
        readonly private IEventsConfig $config,
        readonly private IDIContainer  $diContainer,
    )
    {
    }

    /**
     * Прерывание обработки на первой ошибке.
     * Слушатели должны самостоятельно обрабатывать ошибки.
     * Вызов должен быть обернут в транзакцию БД.
     */
    public function publish(IEvent ...$events): void
    {
        foreach ($events as $event) {
            $listenersClasses = $this->config->listeners()[get_class($event)];
            foreach ($listenersClasses as $listenerClass) {
                $this->listener($listenerClass)->handle($event);
            }
        }
    }

    /**
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    private function listener(string $listenerClass): IEventListener
    {
        return $this->listeners[$listenerClass]
            ?? $this->listeners[$listenerClass] = $this->diContainer->get($listenerClass);
    }
}
