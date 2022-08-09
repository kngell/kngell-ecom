<?php

declare(strict_types=1);

abstract class AbstractController
{
    use ControllerGettersAndSettersTrait;

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

    protected function throwViewException(): void
    {
        if (null === $this->view_instance) {
            throw new BaseLogicException('You can not use the render method if the build in template engine is not available.');
        }
    }

    protected function isValidView() : bool
    {
        if ($this->view_instance === null) {
            throw new BaseLogicException('You cannot use the render method if the View is not available !');
        }
        return true;
    }
}