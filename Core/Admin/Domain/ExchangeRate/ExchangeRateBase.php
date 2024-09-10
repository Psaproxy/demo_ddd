<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate;

use Core\Admin\Domain\ExchangeRate\VO\Amount;
use Core\Common\VO\Currency;
use Core\Common\VO\UUID;

abstract class ExchangeRateBase
{
    protected ?UUID $id;
    protected ?Amount $amount;
    protected \DateTimeImmutable $createdAt;
    protected ?\DateTimeImmutable $updatedAt;

    public function __construct(
        readonly protected bool     $isEnabled,
        readonly protected Currency $currencyFrom,
        readonly protected Currency $currencyTo,
    )
    {
        $this->createdAt = new \DateTimeImmutable();

        //todo Добавить событие добавления нового курса обмена.
    }

    public function id(): ?UUID
    {
        return $this->id;
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

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
