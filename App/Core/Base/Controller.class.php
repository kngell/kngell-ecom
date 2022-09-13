<?php

declare(strict_types=1);

abstract class Controller extends AbstractController
{
    use DatabaseCacheTrait;
    use DisplayFrontEndPagesTrait;
    use ControllerTrait;

    public function __construct(array $params = [])
    {
        $this->properties($params);
    }

    /** @inheritDoc */
    public function __call($name, $argument) : void
    {
        if (is_string($name) && $name !== '') {
            $method = $name . 'Page';
            if (method_exists($this, $method)) {
                if ($this->before() !== false) {
                    call_user_func_array([$this, $method], $argument);
                    $this->after();
                }
            } else {
                throw new BaseBadMethodCallException("Method {$method} does not exists.");
            }
        } else {
            throw new Exception;
        }
    }

    public function isInitialized(string $field) : bool
    {
        $rp = $this->reflectionInstance()->getProperty($field);
        if ($rp->isInitialized($this)) {
            return true;
        }

        return false;
    }

    public function render(string $viewName, array $context = []) : ?string
    {
        $this->throwViewException();
        if ($this->view_instance === null) {
            throw new BaseLogicException('You cannot use the render method if the View is not available !');
        }

        return $this->view_instance->render($viewName, array_merge($this->frontEndComponents, $context));
    }

    public function model(string $modelString) : Object
    {
        return $this->container(ModelFactory::class)->create($modelString);
    }

    public function createView() : void
    {
        if (!isset($this->view_instance)) {
            $this->view_instance = $this->container(View::class, [
                'viewAry' => [
                    'token' => $this->token,
                    'file_path' => $this->filePath,
                    'response' => $this->response,
                    'request' => $this->request,
                ],
            ]);
        }
    }

    public function jsonResponse(array $resp) : void
    {
        $this->response->jsonResponse($resp);
    }

    protected function before() : void
    {
        $this->createView();
        $this->saveViewPage();
        $this->container(Middleware::class)->middlewares(middlewares: $this->callBeforeMiddlewares(), contructorArgs:[])
            ->middleware($this, function ($object) {
                return $object;
            });
    }

    protected function after() : void
    {
        $this->container(Middleware::class)->middlewares(middlewares: $this->callAfterMiddlewares(), contructorArgs:[])
            ->middleware($this, function ($object) {
                return $object;
            });
    }

    protected function brand() : int
    {
        switch ($this->controller) {
            case 'ClothingController':
                return 3;
                break;

            default:
                return 2;
                break;
        }
    }

    protected function redirect(string $url, bool $replace = true, int $responseCode = 303)
    {
        // $this->redirect = new BaseRedirect($url, $this->routeParams, $replace, $responseCode);
        if ($this->redirect) {
            $this->redirect->redirect();
        }
    }
}