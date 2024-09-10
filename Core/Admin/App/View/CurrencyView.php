<?php

declare(strict_types=1);

namespace Core\Admin\App\View;

readonly class CurrencyView
{
    public function __construct(
        public string $code,
        public string $title,
    )
    {
    }
}
