<?php

declare(strict_types=1);

trait ScannerGatterAndSettersTrait
{
    /**
     * Get the value of declaringClass.
     */
    public function getDeclaringClass(): string
    {
        return $this->declaringClass;
    }

    /**
     * Set the value of declaringClass.
     */
    public function setDeclaringClass(string $declaringClass): self
    {
        $this->declaringClass = $declaringClass;

        return $this;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of hasDefaultValue.
     */
    public function isHasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    /**
     * Set the value of hasDefaultValue.
     */
    public function setHasDefaultValue(bool $hasDefaultValue): self
    {
        $this->hasDefaultValue = $hasDefaultValue;

        return $this;
    }

    /**
     * Get the value of nullable.
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * Set the value of nullable.
     */
    public function setNullable(bool $nullable): self
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * Get the value of defaultValue.
     */
    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    /**
     * Set the value of defaultValue.
     */
    public function setDefaultValue($defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Get the value of argument.
     */
    public function getArgument(): mixed
    {
        return $this->argument;
    }

    /**
     * Set the value of argument.
     */
    public function setArgument($argument): self
    {
        $this->argument = $argument;

        return $this;
    }

    /**
     * Get the value of qualifier.
     */
    public function getQualifier(): ?Qualifier
    {
        return $this->qualifier;
    }

    /**
     * Set the value of qualifier.
     */
    public function setQualifier(?Qualifier $qualifier): self
    {
        $this->qualifier = $qualifier;

        return $this;
    }

    /**
     * Get the value of class.
     */
    public function getClass(): ReflectionClass
    {
        return $this->class;
    }

    /**
     * Set the value of class.
     */
    public function setClass(ReflectionClass $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get the value of className.
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Set the value of className.
     */
    public function setClassName(string $className): self
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get the value of constructorAgrs.
     */
    public function getConstructorAgrs(): ContainerConstructorArguments
    {
        return $this->constructorAgrs;
    }

    /**
     * Set the value of constructorAgrs.
     */
    public function setConstructorAgrs(ContainerConstructorArguments $constructorAgrs): self
    {
        $this->constructorAgrs = $constructorAgrs;

        return $this;
    }

    /**
     * Get the value of componentAttr.
     */
    public function getComponentAttr(): ?ContainerComponents
    {
        return $this->componentAttr;
    }

    /**
     * Set the value of componentAttr.
     */
    public function setComponentAttr(?ContainerComponents $componentAttr): self
    {
        $this->componentAttr = $componentAttr;

        return $this;
    }
}
