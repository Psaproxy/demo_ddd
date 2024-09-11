<?php /** @noinspection PhpClassCanBeReadonlyInspection */

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Actions;

use Core\Common\Infra\Queue\IQueueHandler;

class UpdateRatesAmountsHandler implements IQueueHandler
{
    public function __construct(
        readonly private UpdateRatesAmounts $updateRatesAmounts
    )
    {
    }

    public function process(): void
    {
        while (true) {
            $this->updateRatesAmounts->processUpdating();
            usleep(10);
        }
    }
}
