<?php

declare(strict_types=1);

class CustomReflection
{
    private static $instance;
    private ReflectionClass $reflect;

    final public static function getInstance() : self
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function reflectionInstance(string $obj) : ReflectionClass
    {
        if (!isset($this->reflect)) {
            return $this->reflect = new ReflectionClass($obj);
        }
        if ($this->reflect->getName() !== $obj) {
            return $this->reflect = new ReflectionClass($obj);
        }
        return $this->reflect;
    }
}