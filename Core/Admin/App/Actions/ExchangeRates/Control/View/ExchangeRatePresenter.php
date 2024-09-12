<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control\View;

use Core\Admin\Domain\ExchangeRate\Control\DTO\ExchangeRateDTO;
use Core\Common\Domain\DTO\CurrencyDTO;
use Core\Common\View\Helpers\AmountHelper;
use Core\Common\View\Helpers\DateTimeHelper;

readonly class ExchangeRatePresenter
{
    use AmountHelper;
    use DateTimeHelper;

    /**
     * @return ExchangeRateView[]
     * @throws \Throwable
     */
    public function list(ExchangeRateDTO ...$rates): array
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
                new CurrencyDTO($rate->currencyFrom->code, $rate->currencyFrom->title),
                new CurrencyDTO($rate->currencyTo->code, $rate->currencyTo->title),
                $rate->amount !== null ? self::normalizeAmount($rate->amount, 4) : '',
                $rate->updatedAt !== null ? self::normalizeDateTime($rate->updatedAt, self::FORMAT_DATETIME_SIMPLE) : '',
                $hint,
            );
        }, $rates);
    }
}
