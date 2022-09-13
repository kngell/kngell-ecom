<?php

declare(strict_types=1);

use ContainerException;
use Psr\Container\NotFoundExceptionInterface;

class ComponentNotFoundException extends ContainerException implements NotFoundExceptionInterface
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
