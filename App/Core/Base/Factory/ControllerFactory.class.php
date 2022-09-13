<?php

declare(strict_types=1);

class ControllerFactory
{
    private ContainerInterface $container;

    public function __construct(private string $controllerString, private string $method, private string $path, private array $routeParams, private array $controllerProperties)
    {
    }

    public function create() : Controller
    {
        $controllerObject = $this->container->make($this->controllerString, [
            'params' => $this->getControllerParams(),
        ]);
        if (!$controllerObject instanceof Controller) {
            throw new BadControllerExeption($this->controllerString . ' is not a valid Controller');
        }
        $this->container->bind('controller', fn () => $this->controllerString);
        $this->container->bind('method', fn () => $this->method);

        return $controllerObject;
    }

    private function getControllerParams() : array
    {
        return array_merge($this->controllerProperties, [
            'filePath' => $this->path,
            'cachedFiles' => YamlFile::get('cache_files_list'),
            'routeParams' => $this->routeParams,
        ]);
    }
}
