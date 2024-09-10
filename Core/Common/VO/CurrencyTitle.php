<?php

declare(strict_types=1);

namespace Core\Common\VO;

use Core\Common\Exceptions\InvalidArgumentException;

class CurrencyTitle extends Text
{
    public function __construct(
        string|self $value,
    )
    {
        if ($value instanceof static) {
            $valueNormalized = $this->value->value();
        } else {
            $valueNormalized = trim($value);
            if ($valueNormalized === '') {
                throw new InvalidArgumentException("Недоступное значение названия \"$value\". Доступные значения: не пустая строка.");
            }
        }

        parent::__construct($valueNormalized);
    }
}
