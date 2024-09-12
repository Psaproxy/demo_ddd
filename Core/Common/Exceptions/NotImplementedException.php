<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

class NotImplementedException extends LogicException
{
    public function __construct(int $code = 500, ?\Throwable $previous = null)
    {
        parent::__construct("Не реализовано.", $code, $previous);
    }
}
