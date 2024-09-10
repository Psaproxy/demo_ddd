<?php

declare(strict_types=1);

namespace Core\Common\VO;

use Core\Common\Exceptions\InvalidArgumentException;

class Amount
{
    public function __construct(
        protected string|int|float|self $value
    )
    {
        if ($value instanceof self) {
            $valueNormalized = $this->value->value();
        } else {
            $valueNormalized = trim((string)$value);
            if (!is_numeric($valueNormalized)) {
                throw new InvalidArgumentException("Недоступное значение суммы \"$value\". Доступные значения: целое число или число с точкой.");
            }
        }

        $this->value = $valueNormalized;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function lessOrEqual(string|int|float|self $valueTest): bool
    {
        if (!($valueTest instanceof static)) $valueTest = new static($valueTest);

        /**
         * todo Доделать безопасное сравнение. Сейчас для примера.
         */
        return $this->value > $valueTest->value();
    }
}
