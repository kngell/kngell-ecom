<?php

declare(strict_types=1);

class ClassConstructorArguments
{
    use ScannerGatterAndSettersTrait;

    private string $declaringClass;
    private string $name;
    private bool $hasDefaultValue;
    private bool $nullable;
    private mixed $defaultValue;
    private mixed $argument;
    private ?Qualifier $qualifier = null;

    public function __construct(ReflectionParameter $parameter)
    {
        $this->declaringClass = $parameter->getDeclaringClass()->name;
        $this->name = $parameter->getName();
        $this->hasDefaultValue = $parameter->isOptional();
        $this->nullable = $parameter->allowsNull() || $parameter->getType()->allowsNull();
        $this->defaultValue = $this->hasDefaultValue ? $parameter->getDefaultValue() : null;
        $this->argument = $parameter->getType()->getName();
        $this->initQualifier($parameter);
        $this->validdate($parameter);
    }

    public function isFieldOptionnal() : bool
    {
        return $this->hasDefaultValue || $this->nullable;
    }

    public function hasQualifer() : bool
    {
        return $this->qualifer !== null;
    }

    private function initQualifier(ReflectionParameter $parameter) : void
    {
        /** @var ReflectionAttribute */
        $qualifier = ArrayUtil::firstElement($parameter->getAttributes(Qualifier::class, ReflectionAttribute::IS_INSTANCEOF));

        if ($qualifier == null) {
            return;
        }
        $instance = $qualifier->newInstance();
        $this->qualifier = $instance;
    }

    private function validdate(ReflectionParameter $parameter) : void
    {
        if ($this->isFieldOptionnal()) {
            throw new ContainerException(sprintf('Parameter from class "%" can not be optionnal!', $parameter->getName(), $this->declaringClass));
        }
    }
}
