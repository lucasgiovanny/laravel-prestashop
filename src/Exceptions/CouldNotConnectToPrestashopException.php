<?php

namespace LucasGiovanny\LaravelPrestashop\Exceptions;

use Exception;

class CouldNotConnectToPrestashopException extends Exception
{
    public function __construct(string $message = null)
    {
        $e = 'It was not able to connect to Prestashop API';
        $message = $message ? "{$e}: {$message}" : $e;

        parent::__construct($message);
    }
}
