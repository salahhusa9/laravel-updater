<?php

namespace Salahhusa9\Updater\RepositorySource;

use Illuminate\Support\Facades\Http;
use Salahhusa9\Updater\Contracts\Repository;
use Salahhusa9\Updater\Exceptions\GithubConfigException;

class GithubRepository implements Repository
{
    /**
     * getLatestVersion
     */
    public function getLatestVersion(): string
    {
        $this->checkConfig();

        return isset($this->getLatestVersionData()['message']) ? throw new \Exception($this->getLatestVersionData()['message']) : $this->getLatestVersionData()['tag_name'];
    }

    /**
     * getLatestVersionData
     *
     * @return Illuminate\Support\Collection
     */
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

    /**
     * getVersions
     */
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

    /**
     * getVersionsData
     *
     * @return Illuminate\Support\Collection
     */
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

    /**
     * checkConfig
     *
     * @return void
     */
    public function checkConfig()
    {
        if (config('updater.github_token') == null) {
            throw new GithubConfigException('Please set GITHUB_TOKEN in .env file');
        }

        if (config('updater.github_username') == null) {
            throw new GithubConfigException('Please set GITHUB_USERNAME in .env file');
        }

        if (config('updater.github_repository') == null) {
            throw new GithubConfigException('Please set GITHUB_REPOSITORY in .env file');
        }

        return true;
    }
}
