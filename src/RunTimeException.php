<?php

namespace GovInfo;

use Exception;

class RunTimeException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}