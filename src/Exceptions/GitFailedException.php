<?php

namespace Salahhusa9\Updater\Exceptions;

use Exception;

class GitFailedException extends Exception
{
    /**
     * GitFailedException constructor.
     *
     * @param  string  $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
