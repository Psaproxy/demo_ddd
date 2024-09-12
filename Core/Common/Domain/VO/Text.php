<?php

declare(strict_types=1);

namespace Core\Common\Domain\VO;

class Text
{
    public function __construct(
        protected string|int|float|self $value,
    )
    {
        if ($value instanceof static) {
            $valueNormalized = $this->value->value();
        } else {
            $valueNormalized = (string)$value;
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

    public function equal(self|string|float|int $valueTest): bool
    {
        if (!($valueTest instanceof static)) $valueTest = new static($valueTest);

        /**
         * todo Доделать безопасное сравнение. Сейчас для примера.
         */
        return $this->value === $valueTest->value();
    }
}
