<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Salahhusa9\Updater\Contracts\Pipeline;

class SeedersPipe implements Pipeline
{
    public function handle($content, Closure $next)
    {
        Artisan::call('db:seed', [
            '--class' => implode(' --class=', config('updater.seeders')),
            '--force' => true,
        ]);

        return $next($content);
    }
}
