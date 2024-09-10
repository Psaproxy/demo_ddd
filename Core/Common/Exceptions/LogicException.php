<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

class LogicException extends \LogicException implements IException
{
    public function __construct(string $message = "", int $code = 500, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
