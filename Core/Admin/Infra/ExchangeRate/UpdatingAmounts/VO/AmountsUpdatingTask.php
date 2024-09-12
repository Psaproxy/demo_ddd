<?php

declare(strict_types=1);

namespace Core\Admin\Infra\ExchangeRate\UpdatingAmounts\VO;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Queue\QueueTask;
use Random\RandomException;

class AmountsUpdatingTask extends QueueTask
{
    public function __construct(ExchangeRateID $rateID)
    {
        parent::__construct([
            'exchange_rate_id' => $rateID->value(),
        ]);
    }

    /**
     * @throws RandomException
     */
    public function exchangeRateID(): ExchangeRateID
    {
        return new ExchangeRateID($this->getValue('exchange_rate_id'));
    }
}
