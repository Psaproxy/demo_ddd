<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Exceptions;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;

class ExchangeRatesNotExistsException extends \RuntimeException
{
    /**
     * @var ExchangeRateID[]
     */
    private array $idsNotExists;

    public function __construct(
        int                   $code = 0,
        ?\Throwable           $previous = null,
        ExchangeRateID        ...$idsNotExists,
    )
    {
        $this->idsNotExists = $idsNotExists;

        parent::__construct(
            "Не найдены курсы обмена валют с ID: " . implode(",", $idsNotExists),
            $code,
            $previous
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
