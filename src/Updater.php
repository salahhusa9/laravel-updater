<?php

namespace Salahhusa9\Updater;

use Illuminate\Support\Facades\Cache;
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
                Git::fetch();
                Git::pull();
                Git::checkout($version);
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
