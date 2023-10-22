<?php

namespace Salahhusa9\Updater;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Pipeline;
use Salahhusa9\Updater\Contracts\Repository;
use Salahhusa9\Updater\Helpers\Git;

class Updater
{
    public function update(): string
    {
        if (is_array($this->newVersionAvailable())) {
            return $this->updateTo($this->getLatestVersion());
        } else {
            return 'No new version available';
        }
    }

    private function updateTo($version): string
    {
        if (is_array($this->newVersionAvailable()) && $this->newVersionAvailable()['current_version'] != $version) {
            try {

                if (config('updater.maintenance_mode', false)) {
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
                        if (!is_subclass_of($pipeline, \Salahhusa9\Updater\Contracts\Pipeline::class)) {
                            throw new \Exception('Pipeline '. $pipeline .' is not implemented Pipeline contract:' . \Salahhusa9\Updater\Contracts\Pipeline::class);
                        }
                    }
                } else {
                    throw new \Exception('Pipelines is not array or empty');
                }

                Pipeline::send([
                    'current_version' => $this->getCurrentVersion(),
                    'new_version' => $version,
                ])
                    ->through($pipelines)
                    ->then(
                        function ($content) {
                            return $content;
                        }
                    );

                if (config('updater.maintenance_mode', false)) {
                    Artisan::call('up');
                }

                return 'Updated to version '.$version;
            } catch (\Throwable $th) {
                if (config('updater.maintenance_mode', false)) {
                    Artisan::call('up');
                }

                return throw $th;
            }
        } else {
            return 'No new version available';
        }
    }

    public function newVersionAvailable(): bool|array
    {
        $currentVersion = $this->getCurrentVersion();
        $latestVersion = $this->getLatestVersion();

        if ($currentVersion != $latestVersion) {
            return [
                'current_version' => $currentVersion,
                'latest_version' => $latestVersion,
            ];
        }

        return false;
    }

    public function getCurrentVersion(): string
    {
        $branch = Git::getCurrentBranch();
        $tag = Git::getCurrentTag();

        $head = $branch != 'HEAD' ? $branch : $tag;

        return $head;
    }

    public function getLatestVersion(): string
    {
        return Cache::remember('latest_version', 60, function () {
            return app(Repository::class)->getLatestVersion();
        });
    }

    public function versions(): array
    {
        return Cache::remember('versions', 60, function () {
            return app(Repository::class)->getVersions();
        });
    }
}
