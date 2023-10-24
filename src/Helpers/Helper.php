<?php

namespace Salahhusa9\Updater\Helpers;

class Helper
{
    /**
     * isVersion
     *
     * @param  mixed  $version
     * @return int|false
     */
    public function isVersion($version): int|false
    {
        $pattern = '/^v(\d+\.\d+\.\d+)(-[a-zA-Z0-9]+(\.\d+)?)?$/';

        return preg_match($pattern, $version);
    }
}
