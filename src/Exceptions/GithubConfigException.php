<?php

namespace Salahhusa9\Updater\Exceptions;

use Exception;

class GithubConfigException extends Exception
{
    /**
     * GithubConfigException constructor.
     *
     * @param  string  $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
