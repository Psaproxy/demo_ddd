<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\Control;

use Core\Admin\Domain\ExchangeRate\Control\Events\ExchangeRateWasCreated;
use Core\Common\Infra\Event\Events;
use Core\Common\VO\Currency;
use Core\Common\VO\UUID;

class ExchangeRate
{
    use Events;

    protected ?UUID $id;
    protected \DateTimeImmutable $createdAt;

    public function __construct(
        readonly protected bool     $isEnabled,
        readonly protected Currency $currencyFrom,
        readonly protected Currency $currencyTo,
    )
    {
        $this->createdAt = new \DateTimeImmutable();

        $this->addEvents(new ExchangeRateWasCreated($this));
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

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
