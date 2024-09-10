<?php

declare(strict_types=1);

namespace Core\Common\Infra;

interface IDIContainer
{
    public function get(string $classname): object;
}
