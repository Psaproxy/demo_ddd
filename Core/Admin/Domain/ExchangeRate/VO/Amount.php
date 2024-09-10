<?php

declare(strict_types=1);

namespace Core\Admin\Domain\ExchangeRate\VO;

class Amount extends \Core\Common\VO\Amount
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        if ($this->lessOrEqual('0')) {
            throw new \InvalidArgumentException("Недоступное значение суммы \"$value\". Доступные значения: сумма больше 0.0.");
        }
    }
}
