<?php

namespace Salahhusa9\Updater\Tests\RepositorySource;

use Illuminate\Support\Facades\Http;
use Salahhusa9\Updater\Exceptions\GithubConfigException;
use Salahhusa9\Updater\RepositorySource\GithubRepository;

class GithubRepositoryTest extends \Salahhusa9\Updater\Tests\TestCase
{
    /** @test */
    public function config_check()
    {
        // set env
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-updater');

        $githubRepository = new GithubRepository;

        $this->assertTrue($githubRepository->checkConfig());
    }

    /** @test */
    public function config_check_exception()
    {
        $this->expectException(GithubConfigException::class);

        $githubRepository = new GithubRepository;

        $this->assertTrue($githubRepository->checkConfig());
    }

    /** @test */
    public function it_can_get_latest_version()
    {
        // set env
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-updater');

        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-updater/releases/latest' => Http::response([
                'tag_name' => 'v1.0.0',
            ], 200),
        ]);

        $githubRepository = new GithubRepository;

        $this->assertEquals('v1.0.0', $githubRepository->getLatestVersion());
    }

    /** @test */
    public function it_can_get_latest_version_data()
    {
        // set env
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-updater');

        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-updater/releases/latest' => Http::response([
                'tag_name' => 'v1.0.0',
            ], 200),
        ]);

        $githubRepository = new GithubRepository;

        $this->assertIsArray($githubRepository->getLatestVersionData()->toArray());
    }

    /** @test */
    public function it_can_get_versions()
    {
        // set env
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-updater');

        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-updater/releases' => Http::response([
                [
                    'tag_name' => 'v1.0.0',
                ],
                [
                    'tag_name' => 'v1.0.1',
                ],
            ], 200),
        ]);

        $githubRepository = new GithubRepository;

        $this->assertIsArray($githubRepository->getVersions());
    }

    /** @test */
    public function it_can_get_versions_data()
    {
        // set env
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-updater');

        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-updater/releases' => Http::response([
                [
                    'tag_name' => 'v1.0.0',
                ],
                [
                    'tag_name' => 'v1.0.1',
                ],
            ], 200),
        ]);

        $githubRepository = new GithubRepository;

        $this->assertIsArray($githubRepository->getVersionsData()->toArray());
    }
}
