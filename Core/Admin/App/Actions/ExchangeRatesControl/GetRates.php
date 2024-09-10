<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRatesControl;

use Core\Admin\App\Actions\ExchangeRatesControl\View\ExchangeRateView;
use Core\Admin\App\View\ExchangeRatePresenter;
use Core\Admin\Domain\ExchangeRate\IExchangeRateDataProvider;

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
        $rates = $this->dataProvider->findListForControl();

        return $rates ? $this->presenter->listForControl(...$rates) : [];
    }
}
