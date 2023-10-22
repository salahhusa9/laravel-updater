<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallOptimizePipe
{
    public function handle($content, Closure $next)
    {
        Artisan::call('optimize');

        return $next($content);
    }
}
