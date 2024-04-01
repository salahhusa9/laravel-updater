<?php

namespace Salahhusa9\Updater\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Exceptions\GitFailedException;

class Git
{
    /**
     * getCurrentCommit
     *
     * @return string
     *
     * @throws GitFailedException
     */
    public static function getCurrentCommit()
    {
        $process = Process::run(self::gitPath() . ' log --pretty="%h" -n1 HEAD');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * getCurrentBranch
     *
     * @return string
     *
     * @throws GitFailedException
     */
    public static function getCurrentBranch()
    {
        $process = Process::run(self::gitPath() . ' rev-parse --abbrev-ref HEAD');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * getCurrentTag
     *
     * @return string
     *
     * @throws GitFailedException
     */
    public static function getCurrentTag()
    {
        $process = Process::run(self::gitPath() . ' describe --tags --abbrev=0');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * auth
     *
     * @return string
     *
     * @throws GitFailedException
     */
    public static function auth()
    {
        $process = Process::run(self::gitPath() . ' remote set-url origin https://' . config('updater.github_username') . ':' . config('updater.github_token') . '@github.com/' . config('updater.github_username') . '/' . config('updater.github_repository') . '.git');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * pull
     *
     * @return string
     *
     * @throws GitFailedException
     */
    public static function pull()
    {
        $process = Process::run(self::gitPath() . ' pull');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * checkout
     *
     * @param  mixed  $branch
     * @return string
     *
     * @throws GitFailedException
     */
    public static function checkout($branch)
    {
        $process = Process::run(self::gitPath() . ' checkout ' . $branch . ' -f');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * fetch
     *
     * @return string
     *
     * @throws GitFailedException
     */
    public static function fetch()
    {
        $process = Process::run(self::gitPath() . ' fetch');

        if ($process->failed()) {
            throw new GitFailedException('this command failed: ' . $process->command() . ' with message: ' . $process->errorOutput());
        }

        return trim($process->output());
    }

    /**
     * gitPath
     *
     * @return string
     */
    public static function gitPath()
    {
        $gitPath = config('updater.git_path');

        if (!$gitPath) {
            $gitPath = Cache::rememberForever('git_path', function () {
                $executableFinder = new \Symfony\Component\Process\ExecutableFinder();

                $gitPath = $executableFinder->find('git');

                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $gitPath = '"' . $gitPath . '"';
                }

                return $gitPath;
            });
        }

        return $gitPath;
    }
}
