<?php

namespace Salahhusa9\Updater\Helpers;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;

class Git
{
    public static function getCurrentCommit()
    {
        $process = new Process([self::getPath(), 'log', '--pretty="%h"', '-n1', 'HEAD']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function getCurrentBranch()
    {
        $process = new Process([self::getPath(), 'rev-parse', '--abbrev-ref', 'HEAD']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function getCurrentTag()
    {
        $process = new Process([self::getPath(), 'describe', '--tags', '--abbrev=0']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function auth()
    {
        // git remote set-url origin https://username:token@github.com/your/repository.git
        $process = new Process([self::getPath(), 'remote', 'set-url', 'origin', 'https://' . config('updater.github_username') . ':' . config('updater.github_token') . '@github.com/' . config('updater.github_username') . '/' . config('updater.github_repository') . '.git']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function pull()
    {
        $process = new Process([self::getPath(), 'pull']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function checkout($branch)
    {
        $process = new Process([self::getPath(), 'checkout', $branch]);
        $process->run();

        return trim($process->getOutput());
    }

    public static function fetch()
    {
        $process = new Process([self::getPath(), 'fetch']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function getPath()
    {
        $gitPath = config('updater.git_path');

        if (!$gitPath) {
            $gitPath = Cache::rememberForever('git_path', function () {
                $executableFinder = new \Symfony\Component\Process\ExecutableFinder();
                return $executableFinder->find('git');
            });
        }

        return $gitPath;
    }
}
