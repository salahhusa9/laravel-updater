<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallViewClearPipe
{
    public function handle($content, Closure $next)
    {
        Artisan::call('view:clear');

        return $next($content);
    }
}


