<?php

declare(strict_types=1);

interface KernelInterface
{
    const PHP_BOOT_COMPONENTS_NAMESPACES = [
        'App\\Services\\',
    ];

    public function rootDirectory() : string;

    public function handleRequest(RequestHandler $request) : ResponseHandler;
}
