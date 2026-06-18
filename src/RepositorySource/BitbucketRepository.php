<?php

namespace Salahhusa9\Updater\RepositorySource;

use Illuminate\Support\Facades\Http;
use Salahhusa9\Updater\Contracts\Repository;
use Salahhusa9\Updater\Exceptions\BitbucketConfigException;

class BitbucketRepository implements Repository
{
    /**
     * getLatestVersion
     */
    public function getLatestVersion(): string
    {
        $this->checkConfig();

        $latestVersionData = $this->getLatestVersionData();

        if ($message = $this->extractErrorMessage($latestVersionData)) {
            throw new \Exception($message);
        }

        if (! isset($latestVersionData['name'])) {
            throw new \Exception('Unable to determine latest Bitbucket tag.');
        }

        return $latestVersionData['name'];
    }

    /**
     * getLatestVersionData
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestVersionData(): \Illuminate\Support\Collection
    {
        $this->checkConfig();

        $data = $this->requestTags([
            'sort' => '-target.date',
            'pagelen' => 1,
        ]);

        if ($this->extractErrorMessage($data)) {
            return $data;
        }

        return collect($data->get('values', [])[0] ?? []);
    }

    /**
     * getVersions
     */
    public function getVersions(): array
    {
        $this->checkConfig();

        $versionsData = $this->getVersionsData();

        if ($message = $this->extractErrorMessage($versionsData)) {
            throw new \Exception($message);
        }

        return $versionsData->map(function ($version) {
            return $version['name'] ?? null;
        })->filter(function ($version) {
            return $version !== null;
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

        $data = $this->requestTags([
            'pagelen' => 100,
        ]);

        if ($this->extractErrorMessage($data)) {
            return $data;
        }

        $values = collect($data->get('values', []));
        $next = $data->get('next');

        while ($next) {
            $page = $this->httpClient()->get($next)->collect();

            if ($this->extractErrorMessage($page)) {
                return $page;
            }

            $values = $values->merge($page->get('values', []));
            $next = $page->get('next');
        }

        return $values;
    }

    /**
     * checkConfig
     *
     * @return void
     */
    public function checkConfig()
    {
        if (config('updater.bitbucket_username') == null) {
            throw new BitbucketConfigException('Please set BITBUCKET_USERNAME in .env file');
        }

        if (config('updater.bitbucket_password') == null) {
            throw new BitbucketConfigException('Please set BITBUCKET_PASSWORD in .env file');
        }

        if (config('updater.bitbucket_workspace') == null) {
            throw new BitbucketConfigException('Please set BITBUCKET_WORKSPACE in .env file');
        }

        if (config('updater.bitbucket_repo_slug') == null) {
            throw new BitbucketConfigException('Please set BITBUCKET_REPOSITORY in .env file');
        }

        return true;
    }

    private function requestTags(array $query = []): \Illuminate\Support\Collection
    {
        return $this->httpClient()
            ->get($this->getBaseUrl().'/refs/tags', $query)
            ->collect();
    }

    private function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
        ])
            ->withBasicAuth(
                config('updater.bitbucket_username'),
                config('updater.bitbucket_password')
            )
            ->timeout(config('updater.bitbucket_timeout', 100));
    }

    private function getBaseUrl(): string
    {
        return 'https://api.bitbucket.org/2.0/repositories/'.config('updater.workspace').'/'.config('updater.repo_slug');
    }

    private function extractErrorMessage(\Illuminate\Support\Collection $data): ?string
    {
        $payload = $data->all();

        return data_get($payload, 'error.message')
            ?? data_get($payload, 'message');
    }
}
