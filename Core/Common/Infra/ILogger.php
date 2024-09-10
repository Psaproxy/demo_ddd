<?php

declare(strict_types=1);

namespace Core\Common\Infra;

interface ILogger
{
    public function debug(mixed $message): void;

    public function info(mixed $message): void;

    public function notice(mixed $message): void;

    public function warning(mixed $message): void;

    public function error(mixed $message): void;

    public function alarm(mixed $message): void;
}
