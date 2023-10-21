<?php

namespace Salahhusa9\Updater;

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

                $pipelines = [
                    Pipelines\GitPipe::class,
                    Pipelines\ComposerPipe::class,
                ];

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

                Pipeline::send([
                    'version' => $version,
                ])
                    ->through($pipelines)
                    ->then(
                        function ($content) {
                            return $content;
                        }
                    );

                return 'Updated to version ' . $version;
            } catch (\Throwable $th) {
                return $th->getMessage();
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
