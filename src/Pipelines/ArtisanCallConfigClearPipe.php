<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallConfigClearPipe
{
    public function handle($content, Closure $next)
    {
        Artisan::call('config:clear');

        return $next($content);
    }
}
