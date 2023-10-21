<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallRouteClearPipe
{
    public function handle($content, Closure $next)
    {
        Artisan::call('route:clear');

        return $next($content);
    }
}
