<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\ExchangeRate as ExchangeRateBase;
use Core\Admin\Domain\ExchangeRate\VO\Amount;
use Core\Common\VO\CurrencyCode;
use Core\Common\VO\UUID;

class ExchangeRate
{
    readonly protected UUID $id;
    readonly protected CurrencyCode $currencyFromCode;
    readonly protected CurrencyCode $currencyToCode;
    protected ?Amount $newAmount;
    protected ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        throw new \RuntimeException(
            "Создание новой сущности не поддерживается. Для этого необходимо использовать: " . ExchangeRateBase::class
        );
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public function currencyFromCode(): CurrencyCode
    {
        return $this->currencyFromCode;
    }

    public function currencyToCode(): CurrencyCode
    {
        return $this->currencyToCode;
    }

    public function newAmount(): ?Amount
    {
        return $this->newAmount;
    }

    public function updateAmount(Amount $amount): void
    {
        $this->newAmount = $amount;
        $this->updatedAt = new \DateTimeImmutable();

        //todo Добавить событие обновления суммы.
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
