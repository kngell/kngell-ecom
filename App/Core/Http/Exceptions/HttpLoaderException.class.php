<?php

declare(strict_types=1);

class HttpLoaderException extends UnexpectedValueException
{
    public function __construct(string $message, int $code = 0, ?UnexpectedValueException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
