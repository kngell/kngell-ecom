<?php

declare(strict_types=1);

abstract class AbstractRooter
{
    protected RooterHelper $helper;
    protected ResponseHandler $response;
    protected RequestHandler $request;
    protected array $controllerProperties;
    protected string $route = '/';
    protected array $arguments = [];

    public function __construct(?RooterHelper $helper = null, ?ResponseHandler $response = null, ?RequestHandler $request = null, array $controllerProperties = [])
    {
        $this->helper = $helper;
        $this->response = $response;
        $this->request = $request;
        $this->controllerProperties = $controllerProperties;
    }

    /**
     * Get the value of params.
     */
    public function getParams(): mixed
    {
        return $this->params;
    }

    /**
     * Set the value of params.
     */
    public function setParams($params): self
    {
        $this->params = $params;
        return $this;
    }

    protected function getUrl(?string $url) : string
    {
        $url = $url === null ? $this->request->getQuery()->get('url') : $url;
        $url = $this->parseUrl($url);
        $url = $url == 'assets' ? 'assets/getAsset' : $url;
        return $url;
    }

    private function parseUrl(?string $urlroute = null) : string|ResponseHandler
    {
        if ($urlroute != null) {
            if ($urlroute == '') {
                $this->route = $urlroute = DS;
            } elseif ($urlroute == 'favicon.ico') {
                $this->arguments = [$urlroute];
                $this->route = $urlroute = 'assets';
            } else {
                $urlroute = explode(DS, filter_var(rtrim($urlroute, DS), FILTER_SANITIZE_URL));
                if (isset($urlroute[0])) {
                    $this->route = strtolower($urlroute[0]);
                    unset($urlroute[0]);
                }
                if (isset($urlroute[1])) {
                    if ($this->route == 'assets') {
                        if ($urlroute[1] == 'img') {
                            unset($urlroute[1]);
                        }
                    } else {
                        $this->route = $this->route . DS . strtolower($urlroute[1]);
                        unset($urlroute[1]);
                    }
                }
                $this->arguments = count($urlroute) > 0 ? $this->helper->formatUrlArguments(array_values($urlroute)) : [];
            }

            return strtolower($this->route);
        }

        return DS;
    }
}