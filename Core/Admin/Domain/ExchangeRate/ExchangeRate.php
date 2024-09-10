<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate;

use Core\Admin\Domain\ExchangeRate\VO\Amount;

class ExchangeRate extends ExchangeRateBase
{
    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection UnknownInspectionInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct()
    {
        throw new \RuntimeException(
            'Для создания сущности нового курса обмена необходимо использовать: ' . ExchangeRateNew::class
        );
    }

    public function updateAmount(Amount $amount): void
    {
        $this->amount = $amount;
        $this->updatedAt = new \DateTimeImmutable();

        //todo Добавить событие обновления суммы курса обмена.
    }
}
