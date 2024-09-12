<?php

declare(strict_types=1);

namespace Core\Common\Domain\DTO;

readonly class CurrencyDTO
{
    public function __construct(
        public string $code,
        public string $title,
    )
    {
    }
}
