<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Salahhusa9\Updater\Contracts\Pipeline;

class ArtisanCallMigratePipe implements Pipeline
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
            call_user_func($content['output'], 'Start migrating');
        }

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        if (is_callable($content['output'])) {
            call_user_func($content['output'], 'Migrated!');
        }

        return $next($content);
    }
}
