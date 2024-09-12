<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control;

use Core\Admin\App\Actions\ExchangeRates\Control\Exceptions\ExchangeRateAlreadyExistsException;
use Core\Admin\Domain\ExchangeRate\Control\ExchangeRate;
use Core\Admin\Domain\ExchangeRate\Control\IExchangeRateRepository;
use Core\Common\Domain\VO\Currency;
use Core\Common\Domain\VO\CurrencyCode;
use Core\Common\Domain\VO\CurrencyTitle;
use Core\Common\Infra\Event\IEventsPublisher;
use Core\Common\Infra\ITransaction;

readonly class AddRate
{
    public function __construct(
        private ITransaction            $transaction,
        private IEventsPublisher        $eventsPublisher,
        private IExchangeRateRepository $repository,
    )
    {
    }

    /**
     * @throws ExchangeRateAlreadyExistsException
     */
    public function add(
        bool   $isEnabled,
        string $currencyFromCode,
        string $currencyFromTitle,
        string $currencyToCode,
        string $currencyToTitle,
    ): void
    {
        $currencyFromCode = new CurrencyCode($currencyFromCode);
        $currencyFromTitle = new CurrencyTitle($currencyFromTitle);
        $currencyToCode = new CurrencyCode($currencyToCode);
        $currencyToTitle = new CurrencyTitle($currencyToTitle);

        $isRateExists = $this->repository->isExistsByCurrency($currencyFromCode, $currencyToCode);
        if ($isRateExists) throw new ExchangeRateAlreadyExistsException($currencyFromCode, $currencyToCode);

        $rate = new ExchangeRate(
            $isEnabled,
            new Currency(
                new CurrencyCode($currencyFromCode),
                new CurrencyTitle($currencyFromTitle),
            ),
            new Currency(
                new CurrencyCode($currencyToCode),
                new CurrencyTitle($currencyToTitle),
            ),
        );

        $this->transaction->execute(function () use ($rate) {
            $this->repository->add($rate);

            $this->eventsPublisher->publish(...$rate->releaseEvents());
        });
    }
}
