<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\Control\ExchangeRate as ExchangeRateBase;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\Events\ExchangeRateAmountWasCreated;
use Core\Common\Infra\Event\Events;
use Core\Common\VO\CurrencyCode;
use Core\Common\VO\ExchangeRateAmount;
use Core\Common\VO\UUID;

class ExchangeRate
{
    use Events;

    readonly protected UUID $id;
    readonly protected CurrencyCode $currencyFromCode;
    readonly protected CurrencyCode $currencyToCode;
    protected ?ExchangeRateAmount $newAmount;
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

    public function newAmount(): ?ExchangeRateAmount
    {
        return $this->newAmount;
    }

    public function updateAmount(ExchangeRateAmount $amount): void
    {
        $this->newAmount = $amount;
        $this->updatedAt = new \DateTimeImmutable();

        $this->addEvents(new ExchangeRateAmountWasCreated($this->id, $amount));
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
