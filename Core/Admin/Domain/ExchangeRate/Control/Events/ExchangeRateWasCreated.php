<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Control\Events;

use Core\Admin\Domain\ExchangeRate\Control\ExchangeRate;
use Core\Common\Infra\Event\Event;
use Core\Common\VO\UUID;

class ExchangeRateWasCreated extends Event
{
    public function __construct(
        readonly private ExchangeRate $exchangeRate,
    )
    {
        parent::__construct();
    }

    public function id(): UUID
    {
        return $this->exchangeRate->id();
    }
}
