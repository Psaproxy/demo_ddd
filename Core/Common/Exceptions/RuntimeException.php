<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

class RuntimeException extends \RuntimeException implements IException
{
    public function __construct(string $message = "", int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
