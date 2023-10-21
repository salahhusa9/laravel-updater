<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Salahhusa9\Updater\Helpers\Git;

class GitPipe
{
    public function handle($content, Closure $next)
    {
        $version = $content['new_version'];

        Git::auth();
        Git::fetch();
        Git::pull();
        Git::checkout($version);

        return $next($content);
    }
}
