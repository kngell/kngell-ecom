<?php

declare(strict_types=1);

class Application extends AbstractBaseBootLoader
{
    use SystemTrait;

    private RooterInterface $rooter;

    /**
     * Main constructor
     * =========================================================.
     * @param string $appRoot
     */
    public function __construct()
    {
        $this->helper = $this->make(AppUtil::class);
        $this->registerBaseBindings();
        $this->registerBaseAppSingleton();
        parent::__construct();
    }

    public function run()
    {
        BaseConstants::load($this->app());
        $this->phpVersion();
        $this->handleCors();
        $this->loadErrorHandlers();
        $this->loadSession();
        $this->loadCache();
        $this->loadCookies();
        $this->loadEnvironment();
        $this->registeredClass();
        $this->loadRoutes()->resolve();
    }

    /**
     * Turn on global caching from public/index.php bootstrap file to make the cache
     * object available globally throughout the application using the GlobalManager object.
     * @return bool
     */
    public function isCacheGlobal(): bool
    {
        return isset($this->isCacheGlobal) && $this->isCacheGlobal === true ? true : false;
    }

    /**
     * @return string
     * @throws BaseLengthException
     */
    public function getGlobalCacheKey(): string
    {
        if ($this->globalCacheKey !== null && strlen($this->globalCacheKey) < 3) {
            throw new BaseLengthException($this->globalCacheKey . ' is invalid this needs to be more than 3 characters long');
        }

        return ($this->globalCacheKey !== null) ? $this->globalCacheKey : 'cache_global';
    }

    /**
     * Set the application session configuration from the session.yml file else
     * load the core session configration class.
     *
     * @param array $ymlSession
     * @param ?string $newSessionDriver
     * @param bool $isGlobal defaults to false
     * @return self
     * @throws BaseInvalidArgumentException
     */
    public function setSession(array $ymlSession = [], string|null $newSessionDriver = null, bool $isGlobal = false, ?string $globalKey = null): self
    {
        $this->session = !empty($ymlSession) ? $ymlSession : $this->make(SessionConfig::class)->baseConfiguration();
        $this->newSessionDriver = ($newSessionDriver !== null) ? $newSessionDriver : $this->getDefaultSessionDriver();
        $this->isSessionGlobal = $isGlobal;
        $this->globalSessionKey = $globalKey;
        return $this;
    }

    /**
     * Turn on global session from public/index.php bootstrap file to make the session
     * object available globally throughout the application using the GlobalManager object.
     * @return bool
     */
    public function isSessionGlobal(): bool
    {
        return isset($this->isSessionGlobal) && $this->isSessionGlobal === true ? true : false;
    }

    /**
     * @return string
     * @throws BaseLengthException
     */
    public function getGlobalSessionKey(): string
    {
        if ($this->globalSessionKey !== null && strlen($this->globalSessionKey) < 3) {
            throw new BaseLengthException($this->globalSessionKey . ' is invalid this needs to be more than 3 characters long');
        }
        return ($this->globalSessionKey !== null) ? $this->globalSessionKey : 'session_global';
    }

    /**
     * Return the default theme builder library.
     *
     * @return string
     */
    public function getDefaultThemeBuilder(): ?string
    {
        if (count($this->themeBuilderOptions) > 0) {
            foreach ($this->themeBuilderOptions['libraries'] as $key => $value) {
                if (array_key_exists('default', $value)) {
                    if ($value['default'] === true) {
                        return $value['class'];
                    }
                }
            }
        }
    }

    /**
     * Set the application cache configuration from the session.yml file.
     * @param array $ymlCache
     * @param string|null $newCacheDriver
     * @param bool $isGloabl
     * @param string|null $globalKey
     * @return $this
     */
    public function setCache(array $ymlCache = [], ?string $newCacheDriver = null, bool $isGloabl = false, ?string $globalKey = null): self
    {
        $this->cache = (!empty($ymlCache) ? $ymlCache : $this->make(CacheConfig::class)->baseConfiguration());
        $this->newCacheDriver = ($newCacheDriver !== null) ? $newCacheDriver : $this->getDefaultCacheDriver();
        $this->isCacheGlobal = $isGloabl;
        $this->globalCacheKey = $globalKey;
        return $this;
    }

    /**
     * Set the application routes configuration from the session.yml file.
     *
     * @param array $ymlRoutes
     * @param string|null $routeHandler
     * @param string|null $newRouter - accepts the fully qualified namespace of new router class
     * @return self
     */
    public function setRoutes(array $ymlRoutes, string|null $routeHandler = null, string|null $newRouter = null): self
    {
        $this->routes = $ymlRoutes;
        $this->routeHandler = ($routeHandler !== null) ? $routeHandler : $this->defaultRouteHandler();
        $this->newRouter = ($newRouter !== null) ? $newRouter : '';
        return $this;
    }

    /**
     * Undocumented function.
     *
     * @param string $errorClass
     * @param mixed $level
     * @return self
     */
    public function setErrorHandler(array $errorHandling, mixed $level = null): self
    {
        $this->errorHandling = $errorHandling;
        $this->errorLevel = $level;
        return $this;
    }

    /**
     * @param string $handler
     * @return $this
     */
    public function setLogger(string $file, string $handler, string $minLevel, array $options): self
    {
        $this->handler = $handler;
        $this->logFile = $file;
        $this->logOptions = $options;
        $this->logMinLevel = $minLevel;

        return $this;
    }

    public function handleCors()
    {
        $this->make(Cors::class)->handle();
        return $this;
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registeredClass()
    {
        $objs = array_merge($this->helper->dataAccessLayerClass(), $this->helper->bindedClass());
        if (is_array($objs)) {
            foreach ($objs as $obj => $value) {
                $this->bind($obj, $value);
            }
        }
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseAppSingleton()
    {
        $objs = $this->helper->singleton();
        if (is_array($objs)) {
            foreach ($objs as $obj => $value) {
                $this->singleton($obj, $value);
            }
        }
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(Container::class, $this);
    }
}
