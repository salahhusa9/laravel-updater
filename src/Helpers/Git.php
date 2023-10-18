<?php

namespace Salahhusa9\Updater\Helpers;

use Symfony\Component\Process\Process;

class Git
{
    public static function getCurrentCommit()
    {
        $process = new Process(['git', 'log', '--pretty="%h"', '-n1', 'HEAD']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function getCurrentBranch()
    {
        $process = new Process(['git', 'rev-parse', '--abbrev-ref', 'HEAD']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function getCurrentTag()
    {
        $process = new Process(['git', 'describe', '--tags', '--abbrev=0']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function auth()
    {
        // git remote set-url origin https://username:token@github.com/your/repository.git
        $process = new Process(['git', 'remote', 'set-url', 'origin', 'https://'.config('updater.github_username').':'.config('updater.github_token').'@github.com/'.config('updater.github_username').'/'.config('updater.github_repository').'.git']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function pull()
    {
        $process = new Process(['git', 'pull']);
        $process->run();

        return trim($process->getOutput());
    }

    public static function checkout($branch)
    {
        $process = new Process(['git', 'checkout', $branch]);
        $process->run();

        return trim($process->getOutput());
    }

    public static function fetch()
    {
        $process = new Process(['git', 'fetch']);
        $process->run();

        return trim($process->getOutput());
    }
}
