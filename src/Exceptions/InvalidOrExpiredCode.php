<?php

namespace PedroBorges\Authenticator\Exceptions;

use Exception;

class InvalidOrExpiredCode extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (is_null($message)) {
            $message = l('authenticator.securityCode.error');
        }

        parent::__construct($message, $code, $previous);
    }
}
