<?php

namespace PedroBorges\Authenticator\Exceptions;

use Exception;

class InvalidBackupCode extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (is_null($message)) {
            $message = l('authenticator.backupCode.error');
        }

        parent::__construct($message, $code, $previous);
    }
}
