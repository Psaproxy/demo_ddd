<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\Control;

use Core\Admin\App\Actions\ExchangeRates\Control\View\ExchangeRatePresenter;
use Core\Admin\App\Actions\ExchangeRates\Control\View\ExchangeRateView;
use Core\Admin\Domain\ExchangeRate\Control\IExchangeRateDataProvider;

readonly class GetRates
{
    public function __construct(
        private IExchangeRateDataProvider $dataProvider,
        private ExchangeRatePresenter     $presenter,
    )
    {
    }

    /**
     * @return ExchangeRateView[]
     * @throws \Exception
     */
    public function get(): array
    {
        $rates = $this->dataProvider->findList();

        return $rates ? $this->presenter->list(...$rates) : [];
    }
}
