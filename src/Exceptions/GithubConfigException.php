<?php

namespace Salahhusa9\Updater\Exceptions;

use RuntimeException;

class GithubConfigException extends RuntimeException
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
