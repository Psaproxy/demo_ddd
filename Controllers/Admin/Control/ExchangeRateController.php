<?php
/**
 * @noinspection PhpUnused
 * @noinspection UnknownInspectionInspection
 */

declare(strict_types=1);

namespace Controllers\Admin\Control;

use Controllers\BaseController;
use Core\Admin\App\Actions\ExchangeRatesControl\AddRate;
use Core\Admin\App\Actions\ExchangeRatesControl\GetRates;
use Core\Common\VO\CurrencyCode;

class ExchangeRateController extends BaseController
{
    public function __construct(
        private readonly GetRates $getRates,
        private readonly AddRate  $addRate,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function rates(): array
    {
        return self::dtoListToArray($this->getRates->get());
    }

    /**
     * @noinspection PhpUndefinedClassInspection
     * @noinspection UnknownInspectionInspection
     * @noinspection PhpUndefinedMethodInspection
     */
    public function addRate(Request $request): void
    {
        $this->validate($request, [
            'currency_from.code'  => ['required', Rule::in(CurrencyCode::ALL)],
            'currency_from.title' => 'required|min:1|max:100',
            'currency_to.code'    => ['required', Rule::in(CurrencyCode::ALL)],
            'currency_to.title'   => 'required|min:1|max:100',
        ]);
        $isEnabled = $this->request()->boolean('is_enabled');
        $currencyFromCode = $this->request()->string('currency_from.code');
        $currencyFromTitle = $this->request()->string('currency_from.title')->trim();
        $currencyToCode = $this->request()->string('currency_to.code');
        $currencyToTitle = $this->request()->string('currency_to.title')->trim();

        $this->addRate->add(
            $isEnabled,
            $currencyFromCode,
            $currencyFromTitle,
            $currencyToCode,
            $currencyToTitle,
        );
    }
}
