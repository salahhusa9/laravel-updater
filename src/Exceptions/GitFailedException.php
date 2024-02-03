<?php

namespace Salahhusa9\Updater\Exceptions;

use RuntimeException;

class GitFailedException extends RuntimeException
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
