<?php

declare(strict_types=1);

namespace Core\Common\Domain\VO;

readonly class Currency
{
    public function __construct(
        protected CurrencyCode  $code,
        protected CurrencyTitle $title,
    )
    {
    }

    public function __toString(): string
    {
        return $this->code->value();
    }

    public function code(): CurrencyCode
    {
        return $this->code;
    }

    public function title(): CurrencyTitle
    {
        return $this->title;
    }
}
