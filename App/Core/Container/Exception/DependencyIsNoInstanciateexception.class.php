<?php

declare(strict_types=1);

use Psr\Container\NotFoundExceptionInterface;

class DependencyIsNoInstanciateException extends Exception implements NotFoundExceptionInterface
{
}
