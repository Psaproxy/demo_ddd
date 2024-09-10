<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate;

use Core\Admin\Domain\ExchangeRate\VO\Amount;
use Core\Common\VO\Currency;

abstract class ExchangeRateBase
{
    readonly private ?Amount $amount;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;

    public function __construct(
        readonly protected bool     $isEnabled,
        readonly protected Currency $currencyFrom,
        readonly protected Currency $currencyTo,
    )
    {
        $this->createdAt = new \DateTimeImmutable();

        //todo Добавить событие добавления нового курса обмена.
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function currencyFrom(): Currency
    {
        return $this->currencyFrom;
    }

    public function currencyTo(): Currency
    {
        return $this->currencyTo;
    }

    public function amount(): ?Amount
    {
        return $this->amount;
    }

    public function updateAmount(Amount $amount): void
    {
        $this->amount = $amount;
        $this->updatedAt = new \DateTimeImmutable();

        //todo Добавить событие обновления суммы курса обмена.
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
