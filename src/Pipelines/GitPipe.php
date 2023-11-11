<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Salahhusa9\Updater\Contracts\Pipeline;
use Salahhusa9\Updater\Facades\Updater;
use Salahhusa9\Updater\Helpers\Git;

class GitPipe implements Pipeline
{
    /**
     * handle
     *
     * @param  array  $content
     * @param  mixed  $next
     * @return void
     */
    public function handle($content, Closure $next)
    {
        $version = $content['new_version'];

        if (is_callable($content['output'])) {
            call_user_func($content['output'], 'Downloading version '.$version.' ...');
        }

        Git::auth();
        Git::fetch();
        Git::pull();
        $checkout = Git::checkout($version);

        if ($checkout != 'TEST' and  Updater::getCurrentVersion() != $version) {
            if (is_callable($content['output'])) {
                call_user_func($content['output'], 'git checkout failed: '.$checkout);
            }

            return throw new \Exception('git checkout failed: '.$checkout);
        } else {
            if (is_callable($content['output'])) {
                call_user_func($content['output'], 'Checkout success');
            }
        }

        return $next($content);
    }
}
