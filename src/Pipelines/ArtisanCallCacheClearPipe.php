<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallCacheClearPipe
{
    public function handle($content, Closure $next)
    {
        Artisan::call('cache:clear');

        return $next($content);
    }
}


