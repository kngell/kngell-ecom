<?php

declare(strict_types=1);

abstract class AbstractBaseBootLoader extends Container implements ApplicationInterface
{
    use BootstrapTrait;
    use AppGettersAndSettersTrait;

    protected Application $application;
    protected AppUtil $helper;
    protected static string $appRoot;
    protected array $appConfig = [];
    protected array $session;
    protected bool $isSessionGlobal = false;
    protected ?string $globalSessionKey = null;
    protected array $cookie = [];
    protected array $cache = [];
    protected bool $isCacheGlobal = false;
    protected ?string $globalCacheKey = null;
    protected array $routes = [];
    protected array $containerProviders = [];
    protected string|null $routeHandler;
    protected string|null $newRouter;
    protected string|null $theme;
    protected ?string $newCacheDriver;
    protected string $handler;
    protected string $logFile;
    protected array $logOptions = [];
    protected string $logMinLevel;
    protected array $themeBuilderOptions = [];
    protected array $controllerArray = [];

    public function __construct()
    {
        parent::__construct();
    }

        /**
         * Returns the bootstrap appplications object.
         *
         * @return Application
         */
        public function app(): Application
        {
            return self::getInstance();
        }

        /**
         * Set the project root path directory.
         *
         * @param string $rootPath
         * @return void
         */
        public function setPath(string $rootPath): self
        {
            self::$appRoot = rtrim($rootPath, '\/');
            $this->bindPathsInContainer();
            return $this;
        }

        /**
         * Return the document root path.
         *
         * @return string
         */
        public function getPath(string $path = ''): string
        {
            return self::$appRoot . ($path ? DS . $path : $path);
        }

        public function setConst() : self
        {
            $this->make(ConstantConfig::class)->ds()->appConstants(self::$appRoot);
            return $this;
        }

        /**
         * Return the session global variable through a static method which should make
         * accessing the global variable much more simplier
         * returns the session object.
         *
         * @return object
         */
        public static function getSession(): Object
        {
            return GlobalManager::get('session_global');
        }

        /**
         * Initialise the pass our classes to be loaded by the framework dependency
         * container using PHP Reflection.
         *
         * @param string $dependencies
         * @param array $args
         * @return mixed
         */
        public static function diGet(string $class, array $args = []): mixed
        {
            if (!empty($args)) {
                return self::getInstance()->make($class, $args);
            }

            return self::getInstance()->make($class);
        }

        public function loadCache(): CacheInterface
        {
            $cache = $this->make(CacheFacade::class)->create($this->getCacheIdentifier(), $this->getCache());
            if ($this->app()->isCacheGlobal() === true) {
                GLobalManager::set($this->app()->getGlobalCacheKey(), $cache);
            }
            return $cache;
        }

        /**
         * Bind all of the application paths in the container.
         *
         * @return void
         */
        protected function bindPathsInContainer()
        {
            $this->instance('path.appRoot', $this->getPath());
        }

        /**
         * Compare PHP version with the core version ensuring the correct version of
         * PHP and MagmaCore framework is being used at all time in sync.
         *
         * @return void
         */
        protected function phpVersion(): void
        {
            if (version_compare($phpVersion = PHP_VERSION, $coreVersion = $this->getConfig()['app']['app_version'], '<')) {
                die(sprintf('You are runninig PHP %s, but the core framework requires at least PHP %s', $phpVersion, $coreVersion));
            }
        }

        /**
         * Load the framework default enviornment configuration. Most configurations
         * can be done from inside the app.yml file.
         *
         * @return void
         */
        protected function loadEnvironment(): void
        {
            $settings = $this->getConfig()['settings'];
            ini_set('default_charset', $settings['default_charset']);
            date_default_timezone_set($settings['default_timezone']);
        }

        /**
         * Returns an array of the application set providers which will be loaded
         * by the dependency container. Which uses PHP Reflection class to
         * create objects. With a key property which is defined within the yaml
         * providers file.
         *
         * @return array
         */
        protected function loadProviders(): array
        {
            return $this->getContainerProviders();
        }

        protected function loadControllerArray(): array
        {
            return $this->getControllerArray();
        }

        /**
         * Returns the default route handler mechanism.
         *
         * @return string
         */
        protected function defaultRouteHandler(): string
        {
            return $this->make(GlobalVariables::class)->getServer('QUERY_STRING');
        }

        /**
         * Get the default session driver defined with the session.yml file.
         *
         * @return string
         */
        protected function getDefaultSessionDriver(): string
        {
            return $this->getDefaultSettings($this->getSessions());
        }

        /**
         * Get the default cache driver defined with the cache.yml file.
         *
         * @return string
         */
        protected function getDefaultCacheDriver(): string
        {
            return $this->getDefaultSettings($this->getCache());
        }

        /**
         * Builds the application session component and returns the configured object. Based
         * on the session configuration array.
         *
         * @return object - returns the session object
         */
        protected function loadSession(): Object
        {
            $session = $this->make(SessionFacade::class, [
                'sessionEnvironment' => $this->getSessions(),
                'sessionIdentifier' => $this->getSessions()['session_name'],
                'storage' => $this->getSessionDriver(),
            ])->setSession();
            if ($this->app()->isSessionGlobal() === true) {
                GlobalManager::set($this->app()->getGlobalSessionKey(), $session);
            }
            return $session;
        }

        protected function loadRoutes()
        {
            return $this->make(RooterFactory::class, [
                'rooter' => $this->make(RooterInterface::class, [
                    'controllerProperties' => $this->loadProviders(),
                ]),
                'routes' => $this->getRoutes(),
            ])->create();
        }

        protected function loadCookies()
        {
            return $this->make(CookieFacade::class, [
                'cookieEnvironmentArray' => [],
                'cookieConfig' => $this->make(CookieConfig::class),
                'gv' => $this->make(GlobalVariablesInterface::class),
            ])->initialize();
        }

        protected function loadErrorHandlers(): void
        {
            error_reporting($this->getErrorHandlerLevel());
            set_error_handler($this->getErrorHandling()['error']);
            set_exception_handler($this->getErrorHandling()['exception']);
        }
}
