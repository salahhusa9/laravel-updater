<?php

namespace Salahhusa9\Updater\RepositorySource;

use Illuminate\Support\Facades\Http;
use Salahhusa9\Updater\Contracts\Repository;

class GithubRepository implements Repository
{
    public function getLatestVersion(): string
    {
        $this->checkConfig();

        return isset($this->getLatestVersionData()['message']) ? throw new \Exception($this->getLatestVersionData()['message']) : $this->getLatestVersionData()['tag_name'];
    }

    public function getLatestVersionData(): \Illuminate\Support\Collection
    {
        $this->checkConfig();

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'Authorization' => 'Bearer '.config('updater.github_token'),
            'X-GitHub-Api-Version' => '2022-11-28',
        ])
            ->timeout(config('updater.github_timeout', 100))
            ->get('https://api.github.com/repos/'.config('updater.github_username').'/'.config('updater.github_repository').'/releases/latest');

        return $response->collect();
    }

    public function getVersions(): array
    {
        $this->checkConfig();

        $versionsData = $this->getVersionsData();

        if (isset($versionsData['message'])) {
            throw new \Exception($versionsData['message']);
        }

        return $versionsData->map(function ($version) {
            return $version['tag_name'];
        })->toArray();
    }

    public function getVersionsData(): \Illuminate\Support\Collection
    {
        $this->checkConfig();

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'Authorization' => 'Bearer '.config('updater.github_token'),
            'X-GitHub-Api-Version' => '2022-11-28',
        ])
            ->timeout(config('updater.github_timeout', 100))
            ->get('https://api.github.com/repos/'.config('updater.github_username').'/'.config('updater.github_repository').'/releases');

        return $response->collect();
    }

    private function checkConfig()
    {
        if (config('updater.github_token') == null) {
            throw new \Exception('Please set GITHUB_TOKEN in .env file');
        }

        if (config('updater.github_username') == null) {
            throw new \Exception('Please set GITHUB_USERNAME in .env file');
        }

        if (config('updater.github_repository') == null) {
            throw new \Exception('Please set GITHUB_REPOSITORY in .env file');
        }
    }
}
