<?php

namespace Lucasgiovanny\LaravelPrestashop\Exceptions;
use Exception;
use Throwable;
class ResourceMissingAttributes extends Exception
{
    public function __construct(
        string $message = 'Resource is missing data',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
