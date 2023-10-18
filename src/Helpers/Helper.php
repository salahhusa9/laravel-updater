<?php

namespace Salahhusa9\Updater\Helpers;

class Helper
{
    public function isVersion($version)
    {
        $pattern = '/^v(\d+\.\d+\.\d+)(-[a-zA-Z0-9]+(\.\d+)?)?$/';

        return preg_match($pattern, $version);
    }
}
