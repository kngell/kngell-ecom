<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;

class Kernel implements KernelInterface
{
    //DI
    private ClassScanResult $classRessult;
    //State
    private readonly ClassLoader $classLoader;
    private readonly string $env;
    private readonly bool $debug;
    private ContainerInterface $container;
    private ?string $singleClass;

    /**
     * Main class constructor.
     *
     * @param Application $application
     */
    public function __construct(ClassLoader $classLoader, ContainerInterface $container, ?string $singleClass = null, string $env = '', bool $debug = false)
    {
        $this->classLoader = $classLoader;
        $this->env = $env;
        $this->debug = $debug;
        $this->container = $container;
        $this->singleClass = $singleClass;
        $this->classRessult = $this->boot();
    }

    public function rootDirectory(): string
    {
        return '';
    }

    public function componentsScanNamespace(): array
    {
        return [];
    }

    public function handleRequest(RequestHandler $request): ResponseHandler
    {
        return $this->container->make(ResponseHandler::class, ['HTTP_OK', '']);
    }

    private function boot() : ClassScanResult
    {
        return $this->scanForComponents();
    }

    private function scanForComponents() : ClassScanResult
    {
        $scanner = new DiClassScanner($this->classLoader->getPrefixesPsr4(), $this->singleClass);
        return $scanner->scan(
            $this->mergeNamespaces(
                self::PHP_BOOT_COMPONENTS_NAMESPACES,
                $this->componentsScanNamespace()
            )
        );
    }

    private function mergeNamespaces(array $rootNamespace, array $componentNameSpaces) : array
    {
        $namesSpaces = array_merge($rootNamespace, $componentNameSpaces);
        $namesSpaces = array_unique($namesSpaces);
        return array_map(
            fn (string $namesapece) => StringUtil::addTrailingChar('\\', $namesapece),
            $namesSpaces
        );
    }
}
