<?php

namespace LucasGiovanny\LaravelPrestashop\Exceptions;

use Exception;
use Throwable;

class ConfigException extends Exception
{
    public function __construct(
        string $message = 'Client is not correct configured',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
