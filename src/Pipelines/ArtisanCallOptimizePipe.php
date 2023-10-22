<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Salahhusa9\Updater\Contracts\Pipeline;

class ArtisanCallOptimizePipe implements Pipeline
{
    public function handle($content, Closure $next)
    {
        Artisan::call('optimize');

        return $next($content);
    }
}
