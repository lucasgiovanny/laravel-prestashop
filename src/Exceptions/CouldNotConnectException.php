<?php

namespace Lucasgiovanny\LaravelPrestashop\Exceptions;
use Exception;
use Throwable;
class CouldNotConnectException extends Exception
{
    public function __construct(
        string $message = 'Cant connect to the api endpoint',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
