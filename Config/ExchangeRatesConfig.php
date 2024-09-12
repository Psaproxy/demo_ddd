<?php

declare(strict_types=1);

class ExchangeRatesConfig
{
    public function maxAttemptsOfAmountUpdating(): int
    {
        return 10;
    }
}
