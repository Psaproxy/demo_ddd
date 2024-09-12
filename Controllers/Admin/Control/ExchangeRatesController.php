<?php
/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Controllers\Admin\Control;

use Controllers\BaseController;
use Core\Admin\App\Actions\ExchangeRates\Control\AddRate;
use Core\Admin\App\Actions\ExchangeRates\Control\Exceptions\ExchangeRateAlreadyExistsException;
use Core\Admin\App\Actions\ExchangeRates\Control\GetRates;
use Core\Admin\App\Actions\ExchangeRates\Control\UpdateStates;
use Core\Admin\Domain\ExchangeRate\Exceptions\ExchangeRatesNotFoundException;
use Core\Common\Domain\VO\CurrencyCode;

class ExchangeRatesController extends BaseController
{
    public function __construct(
        private readonly GetRates     $getRates,
        private readonly AddRate      $addRate,
        private readonly UpdateStates $updateStates,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function list(): array
    {
        return self::dtoListToArray($this->getRates->list());
    }

    /**
     * @noinspection PhpUndefinedClassInspection
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

        $isEnabled = $request->boolean('is_enabled');
        $currencyFromCode = $request->string('currency_from.code');
        $currencyFromTitle = $request->string('currency_from.title')->trim();
        $currencyToCode = $request->string('currency_to.code');
        $currencyToTitle = $request->string('currency_to.title')->trim();

        try {
            $this->addRate->add(
                $isEnabled,
                $currencyFromCode,
                $currencyFromTitle,
                $currencyToCode,
                $currencyToTitle,
            );
        } catch (ExchangeRateAlreadyExistsException $e) {
            $this->response()->error(
                "Курс обмена валюты \"{$e->currencyFromCode()}\" на \"{$e->currencyToCode()}\" уже имеется.",
                400
            );
        }
    }

    /**
     * @noinspection PhpUndefinedClassInspection
     * @noinspection PhpUndefinedMethodInspection
     * @throws \Throwable
     */
    public function updateStates(Request $request): void
    {
        $newStates = $request->input('new_states');

        try {
            $this->updateStates->update($newStates);
        } catch (ExchangeRatesNotFoundException $e) {
            $this->response()->error(
                "Не найдены курсы обмена валют с ID: " . implode(",", $e->idsNotExists()),
                400
            );
        }
    }
}
