<?php

declare(strict_types=1);

abstract class AbstractController
{
    protected Token $token;
    protected RequestHandler $request;
    protected ResponseHandler $response;
    protected ControllerHelper $helper;
    protected SessionInterface $session;
    protected CookieInterface $cookie;
    protected CacheInterface $cache;
    protected EventDispatcherInterface $dispatcher;
    // protected CommentsInterface $comment;
    protected array $customProperties = [];
    protected array $middlewares = [];
    protected View $view_instance;
    /** @var array */
    protected array $callBeforeMiddlewares = [];
    /** @var array */
    protected array $callAfterMiddlewares = [];
    protected string $filePath;
    protected array $cachedFiles;
    protected array $route_params = [];
    protected array $frontEndComponents = [];

    // public function getComment() : CommentsInterface
    // {
    //     return $this->comment;
    // }

    /**
     * Get the value of filePath.
     */
    public function getFilePath() : string
    {
        return $this->filePath;
    }

    public function view() : View
    {
        return $this->view_instance;
    }

    /**
     * Set the value of filePath.
     *
     * @return  self
     */
    public function setFilePath(string $filePath) : self
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * Get the value of cache.
     */
    public function getCache() : CacheInterface
    {
        return $this->cache;
    }

    /**
     * Set the value of cache.
     *
     * @return  self
     */
    public function setCache(CacheInterface $cache) : self
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * Get the value of cachedFiles.
     */
    public function getCachedFiles() : array
    {
        return $this->cachedFiles;
    }

    /**
     * Set the value of cachedFiles.
     *
     * @return  self
     */
    public function setCachedFiles(array $cachedFiles) : self
    {
        $this->cachedFiles = $cachedFiles;
        return $this;
    }

    public function getPageTitle() : string
    {
        $this->isValidView();
        return $this->view_instance->getPageTitle();
    }

    protected function registerMiddleware(BaseMiddleWare $middleware) : void
    {
        $this->middlewares[] = $middleware;
    }

    protected function registerBeforeMiddleware(array $middlewares = []) : void
    {
        foreach ($middlewares as $name => $middleware) {
            $this->callBeforeMiddlewares[$name] = $middleware;
        }
    }

    protected function getMiddlewares() : array
    {
        return $this->middlewares;
    }

    protected function callAfterMiddlewares(): array
    {
        return $this->callAfterMiddlewares;
    }

    protected function callBeforeMiddlewares(): array
    {
        return array_merge($this->defineCoreMiddeware(), $this->callBeforeMiddlewares);
    }

    protected function defineCoreMiddeware(): array
    {
        return [
            'Error404' => Error404::class,
            // 'ShowCommentsMiddlewares' => ShowCommentsMiddlewares::class,
            'SelectPathMiddleware' => SelectPathMiddleware::class,
        ];
    }

    protected function setLayout(string $layout) : self
    {
        $this->isValidView();
        $this->view_instance->layout($layout);
        return $this;
    }

    protected function pageTitle(?string $page = null)
    {
        $this->isValidView();
        return $this->view_instance->pageTitle($page);
    }

    protected function getView() : View
    {
        $this->isValidView();
        return $this->view_instance;
    }

    protected function geContainer() : ContainerInterface
    {
        return $this->container;
    }

    protected function resetView() : self
    {
        $this->isValidView();
        $this->view_instance->reset();
        return $this;
    }

    protected function siteTitle(?string $title = null) : View
    {
        $this->isValidView();
        return $this->view_instance->siteTitle($title);
    }

    private function isValidView() : bool
    {
        if ($this->view_instance === null) {
            throw new BaseLogicException('You cannot use the render method if the View is not available !');
        }
        return true;
    }
}