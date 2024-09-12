<?php

namespace Core\Common\View\Helpers;

trait AmountHelper
{
    /**
     * todo Добавить нормализацию. Сейчас для примера.
     * @noinspection PhpUnusedParameterInspection
     */
    private static function normalizeAmount(string $amount, int $signAfterDot): string
    {
        return $amount;
    }
}
