<?php

declare(strict_types=1);

class DiClassScanner extends AbstractDiScanner
{
    public function __construct(array $psr4Mapping, ?string $singleClass = null)
    {
        parent::__construct($psr4Mapping, $singleClass);
    }

    public function scan(array $namespaces = []) : ClassScanResult
    {
        $services = [];
        $classes = $this->findClasses($namespaces, $this->singleClass);
        foreach ($classes as $class) {
            $reflectionClass = CustomReflector::getInstance()->getClass($class);
            $classAttr = $reflectionClass->getAttributes(ContainerComponents::class, ReflectionAttribute::IS_INSTANCEOF);
            if (count($classAttr) > 1) {
                throw new ContainerException(sprintf('There is multiple attributes on class "%s"!', $reflectionClass->getName()));
            }
            $services[] = new ClassMetaData($reflectionClass);
        }
        return new ClassScanResult($services);
    }

    public function getReflectionClass(string $class) : ReflectionClass
    {
        try {
            return CustomReflector::getInstance()->getClass($class);
        } catch (ReflectionException $th) {
            //throw $th;
        }
    }
}
