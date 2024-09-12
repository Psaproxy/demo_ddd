<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingState\Events;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Event\Event;

class ExchangeRateStateWasUpdated extends Event
{
    public function __construct(
        readonly private ExchangeRateID $id,
        readonly private bool           $newState,
    )
    {
        parent::__construct();
    }

    public function id(): ExchangeRateID
    {
        return $this->id;
    }

    public function newState(): bool
    {
        return $this->newState;
    }
}
