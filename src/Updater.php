<?php

namespace Salahhusa9\Updater;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Pipeline;
use Salahhusa9\Updater\Contracts\Repository;
use Salahhusa9\Updater\Helpers\Git;

class Updater
{
    private $output;

    /**
     * update
     */
    public function update(?callable $output = null): string
    {
        if (! is_null($output) and ! is_callable($output)) {
            throw new \RuntimeException('Output must be callable');
        }

        $this->output = $output;

        if (is_array($this->newVersionAvailable())) {
            return $this->updateTo($this->getLatestVersion());
        } else {
            return 'No new version available';
        }
    }

    /**
     * updateTo
     *
     * @param  mixed  $version
     */
    private function updateTo($version): string
    {
        if (is_array($this->newVersionAvailable()) && $this->newVersionAvailable()['current_version'] != $version) {

            $current_version_in_past = $this->newVersionAvailable()['current_version'];

            try {
                if (config('updater.maintenance_mode', false)) {
                    $this->output('Maintenance mode is on, turning it on');

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
                            throw new \RuntimeException('Pipeline '.$pipeline.' is not implemented Pipeline contract:'.\Salahhusa9\Updater\Contracts\Pipeline::class);
                        }
                    }
                } else {
                    throw new \RuntimeException('Pipelines is not array or empty');
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
                    $this->output('Maintenance mode is on, turning it off');
                    Artisan::call('up');
                }

                event(new Events\UpdatedSuccessfully($current_version_in_past, $version));

                return 'Updated to version '.$version;
            } catch (\Throwable $th) {
                if (config('updater.maintenance_mode', false)) {
                    $this->output('Maintenance mode is on, turning it off');
                    Artisan::call('up');
                }

                event(new Events\UpdateFailed($current_version_in_past, $version, $th->getMessage()));

                throw $th;
            }
        } else {
            $this->output('No new version available');

            return 'No new version available';
        }
    }

    /**
     * output
     *
     * @param  mixed  $message
     */
    public function output($message): void
    {
        if (is_callable($this->output)) {
            call_user_func($this->output, $message);
        }
    }

    /**
     * newVersionAvailable
     *
     * @return bool
     */
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

    /**
     * getCurrentVersion
     */
    public function getCurrentVersion(): string
    {
        $branch = Git::getCurrentBranch();
        $tag = Git::getCurrentTag();

        $head = $branch != 'HEAD' ? $branch : $tag;

        return $head;
    }

    /**
     * getLatestVersion
     */
    public function getLatestVersion(): string
    {
        return Cache::remember('latest_version', 5, function () {
            return app(Repository::class)->getLatestVersion();
        });
    }

    /**
     * getLatestVersionData
     */
    public function getLatestVersionData(): array
    {
        return Cache::remember('latest_version_data', 5, function () {
            return app(Repository::class)->getLatestVersionData()->toArray();
        });
    }

    /**
     * versions
     */
    public function versions(): array
    {
        return Cache::remember('versions', 5, function () {
            return app(Repository::class)->getVersions();
        });
    }
}
