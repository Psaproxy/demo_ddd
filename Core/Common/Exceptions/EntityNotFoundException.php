<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

class EntityNotFoundException extends RuntimeException
{
    public function __construct(string $id, int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct(
            "Не найдена сущность с ID \"$id\".",
            $code,
            $previous
        );
    }
}
