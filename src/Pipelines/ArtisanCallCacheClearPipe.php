<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Salahhusa9\Updater\Contracts\Pipeline;

class ArtisanCallCacheClearPipe implements Pipeline
{
    /**
     * handle
     *
     * @param  array  $content
     * @param  mixed  $next
     * @return void
     */
    public function handle($content, Closure $next)
    {
        if (is_callable($content['output'])) {
            call_user_func($content['output'], 'Clearing cache...');
        }

        Artisan::call('cache:clear');

        if (is_callable($content['output'])) {
            call_user_func($content['output'], 'Cache cleared!');
        }

        return $next($content);
    }
}
