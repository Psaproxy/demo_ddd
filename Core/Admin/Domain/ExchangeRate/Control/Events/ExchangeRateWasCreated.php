<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Control\Events;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\Event;

class ExchangeRateWasCreated extends Event
{
    public function __construct(
        readonly private ExchangeRateID $exchangeRateID,
    )
    {
        parent::__construct();
    }

    public function id(): ExchangeRateID
    {
        return $this->exchangeRateID;
    }
}
