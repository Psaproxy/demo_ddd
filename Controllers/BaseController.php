<?php

declare(strict_types=1);

namespace Controllers;

abstract class BaseController
{
    protected static function dtoToArray(object $dto): array
    {
        return self::dtoListToarray((array)$dto);
    }

    protected static function dtoListToArray(array $dtoList): array
    {
        array_walk_recursive($dtoList, static function (&$dto) {
            if (is_object($dto)) $dto = (array)$dto;
        });
        return $dtoList;
    }
}
