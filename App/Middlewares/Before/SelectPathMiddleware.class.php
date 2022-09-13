<?php

declare(strict_types=1);

class SelectPathMiddleware extends BeforeMiddleware
{
    public function __construct()
    {
    }

    /**
     * Show User Comment.
     *
     * @param object $middleware
     * @param Closure $next
     * @return mixed
     */
    public function middleware(object $object, Closure $next) : mixed
    {
        if (str_contains($object->getFilePath(), 'Client' . DS)) {
            $object->view()->layout('default');
            $object->frontComponents($object->displayLayout());
        } elseif (str_contains($object->getFilePath(), 'Backend' . DS)) {
            $object->view()->siteTitle("K'nGELL Administration");
            $object->view()->layout('admin');
        }
        return $next($object);
    }
}