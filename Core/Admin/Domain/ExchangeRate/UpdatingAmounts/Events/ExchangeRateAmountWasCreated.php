<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts\Events;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateAmount;
use Core\Common\Infra\Event\Event;
use Core\Common\VO\UUID;

class ExchangeRateAmountWasCreated extends Event
{
    public function __construct(
        readonly private UUID               $id,
        readonly private ExchangeRateAmount $newAmount,
    )
    {
        parent::__construct();
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public function newAmount(): ExchangeRateAmount
    {
        return $this->newAmount;
    }
}
