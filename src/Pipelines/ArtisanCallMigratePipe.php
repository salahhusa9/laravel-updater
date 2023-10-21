<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallMigratePipe
{
    public function handle($content, Closure $next)
    {
        Artisan::call('migrate', [
            '--force' => true,
        ]);

        return $next($content);
    }
}


