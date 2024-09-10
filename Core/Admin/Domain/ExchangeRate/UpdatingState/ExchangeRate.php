<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingState;

use Core\Admin\Domain\ExchangeRate\Control\ExchangeRate as ExchangeRateBase;
use Core\Admin\Domain\ExchangeRate\UpdatingState\Events\ExchangeRateStateWasUpdated;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\Events;

class ExchangeRate
{
    use Events;

    readonly private ExchangeRateID $id;
    readonly private bool $isEnabled;

    public function __construct()
    {
        throw new \RuntimeException(
            "Создание новой сущности не поддерживается. Для этого необходимо использовать: " . ExchangeRateBase::class
        );
    }

    public function id(): ExchangeRateID
    {
        return $this->id;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function updateState(bool $newState): bool
    {
        if ($this->isEnabled === $newState) return false;

        $this->isEnabled = $newState;

        $this->addEvents(new ExchangeRateStateWasUpdated($this->id(), $newState));

        return true;
    }
}
