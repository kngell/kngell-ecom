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

    /**
     * Set the value of commentOutput.
     *
     * @return  self
     */
    public function setCommentsArg(mixed $commentOutput) : self
    {
        $this->customProperties['comments'] = $commentOutput;

        return $this;
    }

    public function frontComponents(array $froncComponents = []) : self
    {
        $this->frontEndComponents = $froncComponents;

        return $this;
    }

    /**
     * Get the value of request.
     */
    public function getRequest() : RequestHandler
    {
        return $this->request;
    }

    /**
     * Set the value of request.
     *
     * @return  self
     */
    public function setRequest(RequestHandler $request) : self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the value of response.
     */
    public function getResponse() : ResponseHandler
    {
        return $this->response;
    }

    /**
     * Set the value of response.
     *
     * @return  self
     */
    public function setResponse(ResponseHandler $response) : self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the value of helper.
     */
    public function getHelper() : ControllerHelper
    {
        return $this->helper;
    }

    /**
     * Set the value of helper.
     *
     * @return  self
     */
    public function setHelper(ControllerHelper $helper) : self
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * Get the value of url.
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * Set the value of url.
     *
     * @return  self
     */
    public function setUrl(string $url) : self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of routeParams.
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    /**
     * Set the value of routeParams.
     */
    public function setRouteParams(array $routeParams): self
    {
        $this->routeParams = $routeParams;

        return $this;
    }

    public function geContainer() : ContainerInterface
    {
        return $this->container;
    }

    /**
     * Get the value of previousPage.
     */
    public function getPreviousPage(): ?string
    {
        return $this->previousPage ?? null;
    }

    protected function reflectionInstance() : ReflectionClass
    {
        return CustomReflector::getInstance()->reflectionInstance($this::class);
    }

    protected function getController() : string
    {
        return $this->controller;
    }

    protected function getMethod() : string
    {
        return $this->method;
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
}