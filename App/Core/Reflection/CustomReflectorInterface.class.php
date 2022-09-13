<?php

declare(strict_types=1);

interface CustomReflectorInterface
{
    public function reflectionInstance(string $obj) : ReflectionClass;

    public function isInitialized(string $field, Object $class) : bool;

    public function getMethod(string $method, object $class) : ReflectionMethod;

    public function getClass(string $obj) : ReflectionClass;
}
