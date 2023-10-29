---
title: how it's work
description: Learn how the internals work and contribute.
---

the proses of update your application is very simple, you just need to run this command:

```shell
php artisan update
```

in background, this command will do the following:

- check if there is a new version of your application.
- download the new version using git commands.
- run the migrations.
- run the seeders.
- clear the cache...
- run the optimize command.
- run the after update pipelines.

all off that do it by run pipelines: 

```javascript

if (config('updater.maintenance_mode', false)) {
    $this->output('Maintenance mode is on, turning it on...');

    Artisan::call(
        'down',
        config('updater.maintenance_mode_secret', false) ? [
            '--secret' => config('updater.maintenance_mode_secret', false),
        ] : []
    );
}

$pipelines = [
    Pipelines\GitPipe::class,
];

if (config('updater.before_update_pipelines', false) && is_array(config('updater.before_update_pipelines')) && count(config('updater.before_update_pipelines')) > 0) {
    $pipelines[] = config('updater.before_update_pipelines');
}

if (config('updater.migrate', false)) {
    $pipelines[] = Pipelines\ArtisanCallMigratePipe::class;
}

if (config('updater.seeders', false) && is_array(config('updater.seeders')) && count(config('updater.seeders')) > 0) {
    $pipelines[] = Pipelines\SeedersPipe::class;
}

if (config('updater.cache:clear', false)) {
    $pipelines[] = Pipelines\ArtisanCallCacheClearPipe::class;
}

if (config('updater.view:clear', false)) {
    $pipelines[] = Pipelines\ArtisanCallViewClearPipe::class;
}

if (config('updater.config:clear', false)) {
    $pipelines[] = Pipelines\ArtisanCallConfigClearPipe::class;
}

if (config('updater.route:clear', false)) {
    $pipelines[] = Pipelines\ArtisanCallRouteClearPipe::class;
}

if (config('updater.optimize', false)) {
    $pipelines[] = Pipelines\ArtisanCallOptimizePipe::class;
}

if (config('updater.after_update_pipelines', false) && is_array(config('updater.after_update_pipelines')) && count(config('updater.after_update_pipelines')) > 0) {
    $pipelines[] = config('updater.after_update_pipelines');
}

// check if pipelines is array and not empty and items is implemented Pipeline contract
if (is_array($pipelines) && count($pipelines) > 0) {
    foreach ($pipelines as $pipeline) {
        if (! is_subclass_of($pipeline, \Salahhusa9\Updater\Contracts\Pipeline::class)) {
            throw new \Exception('Pipeline '.$pipeline.' is not implemented Pipeline contract:'.\Salahhusa9\Updater\Contracts\Pipeline::class);
        }
    }
} else {
    throw new \Exception('Pipelines is not array or empty');
}

$this->output('Start Updating to version '.$version);

Pipeline::send([
    'current_version' => $this->getCurrentVersion(),
    'new_version' => $version,
    'output' => $this->output,
])
    ->through($pipelines)
    ->then(
        function ($content) {
            return $content;
        }
    );

if (config('updater.maintenance_mode', false)) {
    $this->output('Maintenance mode is on, turning it off...');
    Artisan::call('up');
}

event(new Events\UpdatedSuccessfully($current_version_in_past, $version));

return 'Updated to version '.$version;
``` 
