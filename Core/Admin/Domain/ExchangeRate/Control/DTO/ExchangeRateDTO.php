<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Control\DTO;

use Core\Common\DTO\CurrencyDTO;

readonly class ExchangeRateDTO
{
    public function __construct(
        public bool        $isEnabled,
        public CurrencyDTO $currencyFrom,
        public CurrencyDTO $currencyTo,
        public ?string     $amount,
        public int         $createdAt,
        public ?int        $updatedAt,
    )
    {
    }
}
