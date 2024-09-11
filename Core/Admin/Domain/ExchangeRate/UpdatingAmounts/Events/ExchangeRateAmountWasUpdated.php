<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts\Events;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateAmount;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Event\Event;

class ExchangeRateAmountWasUpdated extends Event
{
    public function __construct(
        readonly private ExchangeRateID     $id,
        readonly private ExchangeRateAmount $newAmount,
    )
    {
        parent::__construct();
    }

    public function id(): ExchangeRateID
    {
        return $this->id;
    }

    public function newAmount(): ExchangeRateAmount
    {
        return $this->newAmount;
    }
}
