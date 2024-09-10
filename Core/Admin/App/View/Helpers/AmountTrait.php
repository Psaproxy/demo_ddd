<?php

namespace Core\Admin\App\View\Helpers;

trait AmountTrait
{
    /**
     * todo Добавить нормализацию. Сейчас для примера.
     * @noinspection PhpUnusedParameterInspection
     * @noinspection UnknownInspectionInspection
     */
    private static function normalizeAmount(string $amount, int $signAfterDot): string
    {
        return $amount;
    }
}
