<?php

namespace Salahhusa9\Updater\Helpers;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;

class Git
{
    public static function getCurrentCommit()
    {
        $process = new Process([self::gitPath(), 'log', '--pretty="%h"', '-n1', 'HEAD']);

        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function getCurrentBranch()
    {
        $process = new Process([self::gitPath(), 'rev-parse', '--abbrev-ref', 'HEAD']);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function getCurrentTag()
    {
        $process = new Process([self::gitPath(), 'describe', '--tags', '--abbrev=0']);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function auth()
    {
        // git remote set-url origin https://username:token@github.com/your/repository.git
        $process = new Process([self::gitPath(), 'remote', 'set-url', 'origin', 'https://' . config('updater.github_username') . ':' . config('updater.github_token') . '@github.com/' . config('updater.github_username') . '/' . config('updater.github_repository') . '.git']);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function pull()
    {
        $process = new Process([self::gitPath(), 'pull']);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function checkout($branch)
    {
        $process = new Process([self::gitPath(), 'checkout', $branch]);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function fetch()
    {
        $process = new Process([self::gitPath(), 'fetch']);
        try {
            $process->mustRun();
            return trim($process->getOutput());
        } catch (\Throwable $th) {
            return new \Exception($th->getMessage());
        }
    }

    public static function gitPath()
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
