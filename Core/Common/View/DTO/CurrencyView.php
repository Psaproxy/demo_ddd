<?php

declare(strict_types=1);

namespace Core\Common\View\DTO;

readonly class CurrencyView
{
    public function __construct(
        public string $code,
        public string $title,
    )
    {
    }
}
