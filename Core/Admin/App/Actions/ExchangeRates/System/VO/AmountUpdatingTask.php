<?php /** @noinspection PhpClassCanBeReadonlyInspection */

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\VO;

use Core\Admin\Domain\ExchangeRate\VO\ExchangeRateID;
use Core\Common\Infra\Queue\QueueTask;
use Random\RandomException;

class AmountUpdatingTask extends QueueTask
{
    public function __construct(ExchangeRateID $rateID)
    {
        parent::__construct([
            'exchange_rate_id' => $rateID->value(),
        ]);
    }

    /**
     * @throws RandomException
     */
    public function exchangeRateID(): ExchangeRateID
    {
        return new ExchangeRateID($this->getValue('exchange_rate_id'));
    }
}
