<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Exceptions;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Exceptions\RuntimeException;

class ExchangeRatesNotFoundException extends RuntimeException
{
    /**
     * @var ExchangeRateID[]
     */
    private array $idsNotExists;

    public function __construct(
        ExchangeRateID ...$idsNotExists
    )
    {
        $this->idsNotExists = $idsNotExists;

        parent::__construct(
            "Не найдены курсы обмена валют с ID: " . implode(",", $idsNotExists),
        );
    }

    /**
     * @return ExchangeRateID[]
     */
    public function idsNotExists(): array
    {
        return $this->idsNotExists;
    }
}
