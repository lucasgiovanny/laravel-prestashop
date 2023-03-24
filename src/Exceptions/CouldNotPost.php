<?php

namespace LucasGiovanny\LaravelPrestashop\Exceptions;

use Exception;
use Throwable;

class CouldNotPost extends Exception
{
    public function __construct(
        string $message = 'Could not create new data',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
