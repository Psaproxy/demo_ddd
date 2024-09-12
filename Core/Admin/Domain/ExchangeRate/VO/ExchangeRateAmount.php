<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\VO;

use Core\Common\Domain\VO\Amount;
use Core\Common\Exceptions\InvalidArgumentException;

class ExchangeRateAmount extends Amount
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        if ($this->lessOrEqual(0)) {
            throw new InvalidArgumentException("Недоступное значение суммы \"$value\". Доступные значения: сумма больше 0.0.");
        }
    }
}
