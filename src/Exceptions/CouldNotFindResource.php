<?php

namespace Lucasgiovanny\LaravelPrestashop\Exceptions;
use Exception;
use Throwable;
class CouldNotFindResource extends Exception
{
    public function __construct(
        string $message = 'Resource is not avaible on prestashop',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
