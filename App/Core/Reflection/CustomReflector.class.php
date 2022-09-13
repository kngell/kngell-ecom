<?php

declare(strict_types=1);

class CustomReflector implements CustomReflectorInterface
{
    private static $instance;
    private ReflectionClass $reflect;

    final public static function getInstance() : CustomReflectorInterface
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

    public function getClass(string $obj) : ReflectionClass
    {
        return $this->reflectionInstance($obj);
    }

    public function isInitialized(string $field, Object $class) : bool
    {
        $rp = $this->reflectionInstance($class::class)->getProperty($field);
        if ($rp->isInitialized($class)) {
            return true;
        }

        return false;
    }

    public function getMethod(string $method, object $class) : ReflectionMethod
    {
        return $this->reflectionInstance($class::class)->getMethod($method);
    }
}
