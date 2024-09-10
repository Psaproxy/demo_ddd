<?php
/**
 * @noinspection PhpUnused
 * @noinspection UnknownInspectionInspection
 */

declare(strict_types=1);

namespace Controllers\Admin\Control;

use Controllers\BaseController;
use Core\Admin\App\Actions\ExchangeRates\Control\AddRate;
use Core\Admin\App\Actions\ExchangeRates\Control\Exceptions\ExchangeRateAlreadyExistsException;
use Core\Admin\App\Actions\ExchangeRates\Control\GetRates;
use Core\Common\VO\CurrencyCode;

class ExchangeRatesController extends BaseController
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
    public function list(): array
    {
        return self::dtoListToArray($this->getRates->list());
    }

    /**
     * @noinspection PhpUndefinedClassInspection
     * @noinspection UnknownInspectionInspection
     * @noinspection PhpUndefinedMethodInspection
     */
    public function add(Request $request): void
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

        try {
            $this->addRate->add(
                $isEnabled,
                $currencyFromCode,
                $currencyFromTitle,
                $currencyToCode,
                $currencyToTitle,
            );
        } catch (ExchangeRateAlreadyExistsException) {
            $this->response()->error(
                "Курс обмена валюты \"$currencyFromCode\" на \"$currencyToCode\" уже имеется.",
                400
            );
        }
    }
}
