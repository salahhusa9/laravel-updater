<?php

namespace Salahhusa9\Updater\Helpers;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;

class Composer
{
    public static function install()
    {
        $process = new Process([self::composerPath(), 'install']);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function composerPath()
    {
        $composerPath = config('updater.composer_path');

        if (! $composerPath) {
            $composerPath = Cache::rememberForever('composer_path', function () {
                $executableFinder = new \Symfony\Component\Process\ExecutableFinder();

                return $executableFinder->find('composer');
            });
        }

        return $composerPath;
    }
}
