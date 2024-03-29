<?php

namespace Salahhusa9\Updater\Pipelines;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Salahhusa9\Updater\Contracts\Pipeline;

class SeedersPipe implements Pipeline
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
            call_user_func($content['output'], 'Start seeding');
        }

        $classes = config('updater.seeders', []);

        foreach ($classes as $class) {
            Artisan::call('db:seed', [
                '--class' => $class,
                '--force' => true,
            ]);
        }

        if (is_callable($content['output'])) {
            call_user_func($content['output'], 'Seeded!');
        }

        return $next($content);
    }
}
