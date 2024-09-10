<?php

declare(strict_types=1);

namespace Core\Common\VO;

class UUID extends Text
{
    public function __construct(string|self $value)
    {
        if ($value instanceof self) {
            $valueNormalized = $this->value->value();
        } else {
            $valueNormalized = trim($value);
            /**
             * todo Добавить валидацию с помощью библиотеки UUID.
             */
            if ($valueNormalized === '') {
                throw new \InvalidArgumentException("Недоступное значение UUID \"$value\". Доступные значения: UUID v1-8.");
            }
        }

        parent::__construct($valueNormalized);
    }
}
