<?php

declare(strict_types=1);

final class ArrayUtil
{
    private function __construct()
    {
    }

    public static function isAssoc(array $array) : bool
    {
        return array_values($array) !== $array;
    }

    public static function firstElement(array $array) : mixed
    {
        return empty($array) ? null : $array[0];
    }
}
