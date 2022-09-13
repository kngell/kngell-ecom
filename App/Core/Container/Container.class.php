<?php

declare(strict_types=1);

class Container implements ContainerInterface
{
    use ContainerGettersAndSettersTrait;

    /** @var ContainerInterface */
    protected static $instance;

    /** @var array */
    protected array $instances = [];

    /** @var array */
    protected array $bindings = [];

    /**
     * All of the registered rebound callbacks.
     *
     * @var array
     */
    protected $reboundCallbacks = [];

    public function __construct()
    {
        // $classLoader = require ROOT_DIR . '/vendor/autoload.php';
        // $this->kernel = new Kernel($classLoader, $this, FormBuilder::class);
        // dd($this->kernel);
    }

    /**
     * Get container instance
     * ===============================================.
     * @return mixed
     */
    final public static function getInstance() : mixed
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public static function setInstance(?Application $container = null)
    {
        return static::$instance = $container;
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new ComponentNotFoundException(sprintf('Could not found Component name : %s', $id));
        }

        return $this->instances[$id];
    }

    /**
     * Check is Container as singleton
     *  ==============================================.
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->instances) && isset($this->instances[$id]);
    }

    public function bind(string $abstract, Closure | string | null $concrete = null, bool $shared = false): self
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared,
        ];

        return $this;
    }

    public function singleton(string $abstract, Closure | string | null $concrete = null): self
    {
        return $this->bind($abstract, $concrete, true);
    }

    /**
     * Register an existing instance as shared in the container.
     *
     * @param  string  $abstract
     * @param  mixed  $instance
     * @return mixed
     */
    public function instance(string $abstract, mixed $instance) : mixed
    {
        $isBound = $this->isBound($abstract);
        $this->instances[$abstract] = $instance;
        if ($isBound) {
            $this->rebound($abstract);
        }

        return $instance;
    }

    /**
     * Determine if the given abstract type has been bound.
     * ========================================================.
     * @param  string  $abstract
     * @return bool
     */
    public function isBound($abstract)
    {
        return isset($this->bindings[$abstract]) ||
               isset($this->instances[$abstract]);
    }

    /**
     * Make object
     * ========================================================.
     * @param string $abstract
     * @return mixed
     */
    public function make(string $abstract, array $args = []): mixed
    {
        if ($this->has($abstract)) {
            return $this->instances[$abstract];
        }
        $concrete = $this->bindings[$abstract]['concrete'] ?? $abstract;
        if ($concrete instanceof Closure || $concrete === $abstract) {
            $object = $this->build($concrete, $args);
        } else {
            $object = $this->make($concrete, $args);
        }
        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract]['shared']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Build Objects
     * =========================================================================================.
     * @param Closure|string $concrete
     * @return mixed
     */
    public function build(Closure | string $concrete, array $args = []): mixed
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }
        try {
            /** @var ReflectionClass */
            $reflector = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
        }
        if (!$reflector->isInstantiable()) {
            throw new BindingResolutionException("Target [$concrete] is not instantiable.");
        }
        $constructor = $reflector->getConstructor();
        if ($constructor === null) {
            $obj = $reflector->newInstance();

            return $this->objectWithContainer($obj, $reflector);
        }
        $dependencies = $constructor->getParameters();
        $instances = $this->resolveDependencies($dependencies, $args, $reflector);
        $obj = $reflector->newInstanceArgs($instances);

        return $this->objectWithContainer($obj, $reflector);
    }

    public function flush(): void
    {
        $this->bindings = [];
        $this->instances = [];
    }

    public function getRooter()
    {
        return $this->rooter;
    }

    /**
     * Resolve Dependencies
     * =========================================================================================.
     * @param array $dependencies
     * @return array
     */
    protected function resolveDependencies(array $dependencies, array $args, reflectionClass $reflector): array
    {
        $results = [];
        foreach ($dependencies as $key => $dependency) {
            $type = $dependency->getType(); // ReflectionType|null
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($dependency->isDefaultValueAvailable() || !empty($args)) {
                    if ($dependency->isDefaultValueAvailable() && !array_key_exists($dependency->name, $args)) {
                        $results[] = $dependency->getDefaultValue();
                    }
                    if (array_key_exists($dependency->name, $args)) {
                        $results[] = $args[$dependency->name];
                    } elseif (array_key_exists($key, $args)) {
                        $results[] = $args[$key];
                    }
                } else {
                    throw new DependencyHasNoDefaultValueException('Sorry cannot resolve class dependency ' . $dependency->name);
                }
            } elseif (!$reflector->isUserDefined()) {
                $results[] = $this->make($dependency->name);
            } else {
                if (array_key_exists($dependency->name, $args)) {
                    $results[] = $args[$dependency->name];
                } elseif (array_key_exists($key, $args)) {
                    $results[] = $args[$key];
                } else {
                    $results[] = $this->make($type->getName());
                }
            }
        }

        return $results;
    }

    /**
     * Fire the "rebound" callbacks for the given abstract type.
     *
     * @param  string  $abstract
     * @return void
     */
    protected function rebound($abstract)
    {
        $instance = $this->make($abstract);
        foreach ($this->getReboundCallbacks($abstract) as $callback) {
            call_user_func($callback, $this, $instance);
        }
    }

    /**
     * Get the rebound callbacks for a given type.
     *
     * @param  string  $abstract
     * @return array
     */
    protected function getReboundCallbacks($abstract)
    {
        return $this->reboundCallbacks[$abstract] ?? [];
    }

    /**
     * Set Container into created object
     * =========================================================================================.
     * @param ReflectionClass $reflector
     * @param object $obj
     * @return void
     */
    protected function objectWithContainer(Object $obj, $reflector)
    {
        if ($reflector->hasProperty('container')) {
            $reflectionContainer = $reflector->getProperty('container');
            $reflectionContainer->setAccessible(true);
            if (!$reflectionContainer->isInitialized($obj)) {
                $reflectionContainer->setValue($obj, $this);
            }
        }

        return $obj;
    }
}
