<?php

namespace LucasGiovanny\LaravelPrestashop\Exceptions;

use Exception;

class InvalidePrestashopFilterException extends Exception
{
    public function __construct()
    {
        parent::__construct('This filter operator is not a Prestashop valid operator');
    }
}
