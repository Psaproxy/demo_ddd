<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Control;

use Core\Admin\Domain\ExchangeRate\Control\Events\ExchangeRateWasCreated;
use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Domain\VO\Currency;
use Core\Common\Event\Events;

readonly class ExchangeRate
{
    use Events;

    protected ExchangeRateID $id;
    protected \DateTimeImmutable $createdAt;

    public function __construct(
        private bool     $isEnabled,
        private Currency $currencyFrom,
        private Currency $currencyTo,
    )
    {
        $this->id = new ExchangeRateID();
        $this->createdAt = new \DateTimeImmutable();

        $this->addEvents(new ExchangeRateWasCreated($this->id));
    }

    public function id(): ExchangeRateID
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

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
