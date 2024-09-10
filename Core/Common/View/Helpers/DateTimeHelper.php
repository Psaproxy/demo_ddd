<?php

namespace Core\Common\View\Helpers;

use Core\Common\Exceptions\InvalidArgumentException;

trait DateTimeHelper
{
    private const int FORMAT_DATETIME_SIMPLE = 1;
    private const array FORMAT_DATETIME_ALL = [
        self::FORMAT_DATETIME_SIMPLE,
    ];

    /**
     * @throws \Exception
     */
    private static function normalizeDateTime(int $timestamp, int $format): string
    {
        return match ($format) {
            self::FORMAT_DATETIME_SIMPLE => (new \DateTimeImmutable($timestamp))->format('H:i d.m.Y'),
            default => throw new InvalidArgumentException(
                "Недоступное значение формата \"$format\". Доступные значения: " . implode(',', self::FORMAT_DATETIME_ALL)
            ),
        };
    }
}
