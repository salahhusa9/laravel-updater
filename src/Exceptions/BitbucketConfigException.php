<?php

namespace Salahhusa9\Updater\Exceptions;

use RuntimeException;

class BitbucketConfigException extends RuntimeException
{
    /**
     * BitbucketConfigException constructor.
     *
     * @param  string  $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
