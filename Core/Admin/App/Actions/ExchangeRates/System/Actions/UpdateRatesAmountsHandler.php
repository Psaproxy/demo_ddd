<?php

declare(strict_types=1);

namespace Core\Admin\App\Actions\ExchangeRates\System\Actions;

use Core\Common\App\Queue\QueueHandler;
use Core\Common\Infra\ILogger;

class UpdateRatesAmountsHandler extends QueueHandler
{
    public function __construct(
        ILogger                             $logger,
        readonly private UpdateRatesAmounts $updateRatesAmounts,
    )
    {
        parent::__construct($logger);
    }

    protected function iteration(): void
    {
        $this->updateRatesAmounts->processUpdating();
    }
}
