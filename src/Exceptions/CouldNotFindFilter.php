<?php

namespace Lucasgiovanny\LaravelPrestashop\Exceptions;
use Exception;
use Throwable;
class CouldNotFindFilter extends Exception
{
    public function __construct(
        string $message = 'Filter is not avaible on prestashop',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
