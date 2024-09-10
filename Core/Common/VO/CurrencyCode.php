<?php

declare(strict_types=1);

namespace Core\Common\VO;

use Core\Common\Exceptions\InvalidArgumentException;

class CurrencyCode extends Text
{
    public const string RUB = 'RUB';
    public const string USD = 'USD';
    public const array ALL = [
        self::RUB,
        self::USD,
    ];

    public function __construct(
        string|self $value,
    )
    {
        if ($value instanceof static) {
            $valueNormalized = $this->value->value();
        } else {
            $valueNormalized = strtoupper(trim($value));
            if (!in_array($valueNormalized, self::ALL, true)) {
                throw new InvalidArgumentException("Недоступное значение кода валюты \"$value\". Доступные значения: " . implode(',', self::ALL));
            }
        }

        parent::__construct($valueNormalized);
    }
}
