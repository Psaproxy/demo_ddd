<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\Control\ExchangeRates;

use Core\Admin\Domain\ExchangeRate\UpdatingAmounts\IExchangeRateRepository;
use Core\Common\Infra\ITransaction;

readonly class UpdateRatesAmounts
{
    public function __construct(
        private ITransaction            $transaction,
        private IExchangeRateRepository $repository,
    )
    {
    }

    public function updateEnabled(): void
    {
        $rates = $this->repository->findEnabled();
        if (!$rates) return;

        $newAmounts = $this->repository->findNewAmounts(...$rates);

        $newAmounts_ = [];
        foreach ($newAmounts as $newAmount) {
            $newAmounts_["{$newAmount->currencyFromCode()}-{$newAmount->currencyToCode()}"] = $newAmount;
        }
        $newAmounts = $newAmounts_;

        foreach ($rates as $rate) {
            $this->transaction->execute(function () use ($rate, $newAmounts) {
                $newAmount = $newAmounts["{$rate->currencyFromCode()}-{$rate->currencyToCode()}"];
                if ($newAmount === null) {
                    //todo Запись error-лога.
                    return;
                }

                $rate->updateAmount($newAmount->amount());

                $this->repository->updateAmount($rate);

                //todo Добавить обработку событий из сущности $rate.
            });
        }
    }
}
