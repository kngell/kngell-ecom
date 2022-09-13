<?php

declare(strict_types=1);

abstract class AbstractDiScanner
{
    protected array $psr4Mapping;
    protected ?string $singleClass;

    public function __construct(array $psr4Mapping, ?string $singleClass = null)
    {
        $this->psr4Mapping = $psr4Mapping;
        $this->singleClass = $singleClass;
    }

    /**
     * FindClasses.
     *
     * @param string[] $namespaces
     * @return array
     * @throws ContainerException
     */
    protected function findClasses(array $namespaces = [], ?string $singleClass = null) : array
    {
        $classes = [];
        if (!empty($namespaces)) {
            $classes = array_merge($classes, $this->findClassesWithNameSpaces($namespaces));
        }
        return $singleClass !== null ? array_merge($classes, [$singleClass]) : $classes;
    }

private function findClassesWithNameSpaces(array $namespaces = []) : array
{
    $classes = [];
    foreach ($namespaces as $namespace) {
        $psr4Mapping = $this->findPsr4Mapping($namespace);
        foreach ($psr4Mapping->getValue() as $dir) {
            $newClasses = FileScanner::scanForClassesInNamespace($psr4Mapping->getKey(), $dir, true);
            $classes = array_merge($classes, $newClasses);
        }
    }
    return $classes;
}

    private function findPsr4Mapping(string $namespace) : Pair
    {
        if (!array_key_exists($namespace, $this->psr4Mapping)) {
            throw new ContainerException(sprintf('Could not find any Psr 4 Mapping for the namespace "%s".', $namespace));
        }
        return new Pair($namespace, $this->psr4Mapping[$namespace]);
    }
}
