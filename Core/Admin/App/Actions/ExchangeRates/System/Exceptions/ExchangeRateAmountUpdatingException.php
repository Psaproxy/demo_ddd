<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Exceptions;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Exceptions\RuntimeException;

class ExchangeRateAmountUpdatingException extends RuntimeException
{
    public function __construct(
        private readonly ExchangeRateID $rateID,
        private readonly string         $errorMessage,
    )
    {
        parent::__construct(
            "Не удалось обновить сумму курса обмена валюты с ID \"$this->rateID\". Ошибка: $this->errorMessage",
        );
    }

    public function exchangeRateID(): ExchangeRateID
    {
        return $this->rateID;
    }
}
