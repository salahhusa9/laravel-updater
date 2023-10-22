<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Salahhusa9\Updater\Facades\Updater;
use Salahhusa9\Updater\Helpers\Git;

class GitPipe
{
    public function handle($content, Closure $next)
    {
        $version = $content['new_version'];

        Git::auth();
        Git::fetch();
        Git::pull();
        $checkout = Git::checkout($version);

        if (Updater::getCurrentVersion() != $version) {
            return throw new \Exception('git checkout failed: '.$checkout);
        }

        return $next($content);
    }
}
