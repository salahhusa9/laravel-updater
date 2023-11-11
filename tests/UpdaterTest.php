<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Facades\Updater;
use Salahhusa9\Updater\Tests\TestCase;

class UpdaterTest extends TestCase
{
    public function testGetCurrentVersion()
    {
        config()->set('updater.git_path', 'git');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
        ]);

        $this->assertEquals('1.0.0', Updater::getCurrentVersion());
    }

    public function testGetLatestVersion()
    {
        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-test/releases/latest' => Http::response([
                'tag_name' => '1.0.1',
            ], 200),
        ]);

        config()->set('updater.git_path', 'git');
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-test');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
            'git pull' => '',
            'git checkout 1.0.1' => 'TEST',
            'git remote set-url origin https://salahhusa9:salahhusa9@github.com/salahhusa9/laravel-test.git' => '',
            'git fetch' => ''
        ]);

        $this->assertEquals('1.0.1', Updater::getLatestVersion());
    }

    public function testGetLatestVersionData()
    {
        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-test/releases/latest' => Http::response([
                'tag_name' => '1.0.1',
            ], 200),
        ]);

        config()->set('updater.git_path', 'git');
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-test');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
            'git pull' => '',
            'git checkout 1.0.1' => 'TEST',
            'git remote set-url origin https://salahhusa9:salahhusa9@github.com/salahhusa9/laravel-test.git' => '',
            'git fetch' => ''
        ]);

        $this->assertEquals(['tag_name' => '1.0.1'], Updater::getLatestVersionData());
    }

    public function testVersions()
    {
        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-test/releases' => Http::response([
                [
                    'tag_name' => '1.0.0',
                ],
                [
                    'tag_name' => '1.1.0',
                ],
                [
                    'tag_name' => '2.0.0',
                ],
            ], 200),
        ]);

        config()->set('updater.git_path', 'git');
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-test');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
            'git pull' => '',
            'git checkout 1.0.1' => 'TEST',
            'git remote set-url origin https://salahhusa9:salahhusa9@github.com/salahhusa9/laravel-test.git' => '',
            'git fetch' => ''
        ]);

        $this->assertEquals(['1.0.0', '1.1.0', '2.0.0'], Updater::versions());
    }

    public function testNewVersionAvailable()
    {
        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-test/releases/latest' => Http::response([
                'tag_name' => '1.0.1',
            ], 200),
        ]);

        config()->set('updater.git_path', 'git');
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-test');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
            'git pull' => '',
            'git checkout 1.0.1' => 'TEST',
            'git remote set-url origin https://salahhusa9:salahhusa9@github.com/salahhusa9/laravel-test.git' => '',
            'git fetch' => ''
        ]);

        $this->assertEquals(['current_version' => '1.0.0', 'latest_version' => '1.0.1'], Updater::newVersionAvailable());
    }

    public function testUpdate()
    {
        Event::fake();
        // Artisan::fake();

        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-test/releases/latest' => Http::response([
                'tag_name' => '1.0.1',
            ], 200),
        ]);

        config()->set('updater.git_path', 'git');
        config()->set('updater.github_token', 'salahhusa9');
        config()->set('updater.github_username', 'salahhusa9');
        config()->set('updater.github_repository', 'laravel-test');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
            'git pull' => '',
            'git checkout 1.0.1' => 'TEST',
            'git remote set-url origin https://salahhusa9:salahhusa9@github.com/salahhusa9/laravel-test.git' => '',
            'git fetch' => ''
        ]);

        // Artisan::shouldReceive('call')->once()->with('up');
        $this->assertEquals('Updated to version 1.0.1', Updater::update());

        // Test update failure
        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => 'HEAD',
            'git describe --tags --abbrev=0' => '1.0.0',
            'git pull origin HEAD' => '',
            'git checkout 1.0.1' => '...',
            'git remote set-url origin https://salahhusa9:salahhusa9@github.com/salahhusa9/laravel-test.git' => '',
            'git fetch' => ''
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('git checkout failed: ...');
        Updater::update();
    }
}
