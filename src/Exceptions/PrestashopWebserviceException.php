<?php

namespace LucasGiovanny\LaravelPrestashop\Exceptions;

use Exception;
use Throwable;

class PrestashopWebserviceException extends Exception
{
    public function __construct(
        string $message = 'The webservice returned a exception',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
