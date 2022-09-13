<?php

declare(strict_types=1);

class ClassMetaData
{
    use ScannerGatterAndSettersTrait;

    private ReflectionClass $class;
    private string $name;
    private string $className;
    /** @var ClassConstructorArguments */
    private array $constructorAgrs = [];
    private ?ContainerComponents $classAttr;

    public function __construct(ReflectionClass $class)
    {
        $this->class = $class;
        $this->className = $class->getName();
        $this->loadAttribute($class->getAttributes());
        $this->loadContructorAgrs($class->getConstructor());
    }

    /**
     * Load class attributes.
     *
     * @param ReflectionAttribute[] $classAttr
     * @return void
     */
    private function loadAttribute(array $classAttr) : void
    {
        foreach ($classAttr as $attr) {
            $instance = $attr->newInstance();
            if ($instance instanceof ContainerComponents) {
                $this->classAttr = $instance;
                $this->name = StringUtil::isBlank($instance->name) ? $this->className : $instance->name;
            }
        }
    }

    private function loadContructorAgrs(?ReflectionMethod $constructor) : void
    {
        $this->constructorAgrs = [];
        if ($constructor == null) {
            return;
        }
        foreach ($constructor->getParameters() as $dependency) {
            if (!$dependency->hasType()) {
                throw new ContainerException(sprintf('Class dependency "%s" must have a type!', $dependency->getName(), $this->className));
            }
            $this->constructorAgrs[] = new ClassConstructorArguments($dependency);
        }
    }
}
