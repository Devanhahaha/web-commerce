<?php

namespace App\Exceptions;

use Exception;

class RajaOngkirException extends Exception
{
    public function __construct($message = "Terjadi kesalahan pada API Raja Ongkir.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
