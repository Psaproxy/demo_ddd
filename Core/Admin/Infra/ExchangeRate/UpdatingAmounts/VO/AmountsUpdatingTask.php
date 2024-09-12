<?php

declare(strict_types=1);

namespace Core\Admin\Infra\ExchangeRate\UpdatingAmounts\VO;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Queue\QueueTask;

class AmountsUpdatingTask extends QueueTask
{
    public function __construct(ExchangeRateID $rateID)
    {
        parent::__construct([
            'exchange_rate_id' => $rateID->value(),
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function exchangeRateID(): ExchangeRateID
    {
        return $this->getTaskValue('exchange_rate_id', function (string $rateId): ExchangeRateID {
            return new ExchangeRateID($rateId);
        });
    }
}
