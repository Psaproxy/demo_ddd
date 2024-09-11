<?php

declare(strict_types=1);

namespace Core\Common\VO;

use Core\Common\Exceptions\InvalidArgumentException;
use Random\RandomException;

class UUID extends Text
{
    /**
     * @throws RandomException
     */
    public function __construct(null|string|self $value = null)
    {
        if (null === $value) {
            $valueNormalized = self::generate();
        } elseif ($value instanceof self) {
            $valueNormalized = $this->value->value();
        } else {
            $valueNormalized = trim($value);
            /**
             * todo Добавить валидацию с помощью библиотеки UUID.
             */
            if ($valueNormalized === '') {
                throw new InvalidArgumentException("Недоступное значение UUID \"$value\". Доступные значения: UUID v1-8.");
            }
        }

        parent::__construct($valueNormalized);
    }

    /**
     * todo Заменить на библиотеку ramsey/uuid.
     * @throws RandomException
     */
    private static function generate(): string
    {
        $value = random_bytes(16);
        $value[6] = chr(ord($value[6]) & 0x0f | 0x40);
        $value[8] = chr(ord($value[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($value), 4));
    }
}
