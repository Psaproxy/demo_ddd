<?php

declare(strict_types=1);

namespace Core\Common\Infra;

interface ITransaction
{
    public function execute(callable $processing): mixed;

    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;
}
