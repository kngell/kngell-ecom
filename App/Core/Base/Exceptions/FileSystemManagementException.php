<?php

declare(strict_types=1);

use FileException;

class FileSystemManagementException extends FileException
{
    public function __construct(string $message, int $code = 0, ?FileException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
