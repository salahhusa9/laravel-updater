<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Salahhusa9\Updater\Helpers\Composer;

class ComposerPipe
{
    public function handle($content, Closure $next)
    {
        Composer::install();

        return $next($content);
    }
}


