<?php

declare(strict_types=1);

trait ControllerGettersAndSettersTrait
{
    public function getSession(): SessionInterface
    {
        return $this->session;
    }

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

    protected function getController() : string
    {
        return $this->controller;
    }

    protected function getMethod() : string
    {
        return $this->method;
    }

    protected function getRoutes(): array
    {
        return $this->routeParams;
    }

    protected function getSiteUrl(?string $path = null): string
    {
        return sprintf('%s://%s%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], ($path !== null) ? $path : $_SERVER['REQUEST_URI']);
    }

    protected function getMiddlewares() : array
    {
        return $this->middlewares;
    }

    protected function callAfterMiddlewares(): array
    {
        return $this->callAfterMiddlewares;
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
}