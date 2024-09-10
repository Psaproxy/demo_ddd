<?php

declare(strict_types=1);

namespace Core\Admin\App\View;

use Core\Admin\App\Actions\ExchangeRatesControl\View\ExchangeRateView;
use Core\Admin\App\View\Helpers\AmountTrait;
use Core\Admin\App\View\Helpers\DateTimeTrait;
use Core\Admin\Domain\ExchangeRate\DTO\ExchangeRateDTO;

readonly class ExchangeRatePresenter
{
    use AmountTrait;
    use DateTimeTrait;

    /**
     * @return ExchangeRateView[]
     * @throws \Exception
     */
    public function listForControl(ExchangeRateDTO ...$rates): array
    {
        if (!$rates) return [];

        return array_map(static function (ExchangeRateDTO $rate): ExchangeRateView {
            $hint = '';
            if ($rate->amount === null || $rate->updatedAt === null) {
                $hint = 'Курс валюты еще не получен.';
            } else {
                $updatedAt = (new \DateTimeImmutable())->setTimestamp($rate->updatedAt)->setTime(0, 0)->getTimestamp();
                $currentDay = (new \DateTimeImmutable())->setTime(0, 0)->getTimestamp();
                if ($updatedAt < $currentDay) {
                    $hint = 'Курс валюты будет обновлен в ближайшее время.';
                }
            }

            return new ExchangeRateView(
                $rate->isEnabled,
                new CurrencyView($rate->currencyFrom->code, $rate->currencyFrom->title),
                new CurrencyView($rate->currencyTo->code, $rate->currencyTo->title),
                $rate->amount !== null ? self::normalizeAmount($rate->amount, 4) : '',
                $rate->updatedAt !== null ? self::normalizeDateTime($rate->updatedAt, self::FORMAT_DATETIME_SIMPLE) : '',
                $hint,
            );
        }, $rates);
    }
}
