<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\UpdatingAmounts;

use Core\Admin\Domain\ExchangeRate\Control\ExchangeRate as ExchangeRateBase;
use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\Events\ExchangeRateAmountWasUpdated;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateAmount;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Exceptions\LogicException;
use Core\Common\Infra\Event\Events;
use Core\Common\VO\CurrencyCode;

class ExchangeRate
{
    use Events;

    readonly private ExchangeRateID $id;
    readonly private CurrencyCode $currencyFromCode;
    readonly private CurrencyCode $currencyToCode;
    protected ?ExchangeRateAmount $newAmount;
    protected ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        throw new LogicException(
            "Создание новой сущности не поддерживается. Для этого необходимо использовать: " . ExchangeRateBase::class
        );
    }

    public function id(): ExchangeRateID
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

    public function updateAmount(ExchangeRateAmount $amount): bool
    {
        $this->newAmount = $amount;
        $this->updatedAt = new \DateTimeImmutable();

        $this->addEvents(new ExchangeRateAmountWasUpdated($this->id, $amount));

        return true;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
