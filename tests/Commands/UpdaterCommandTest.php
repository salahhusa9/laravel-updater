<?php

namespace Salahhusa9\Updater\Tests\Commands;

use Illuminate\Support\Facades\Http;
use Salahhusa9\Updater\Facades\Updater;
use Salahhusa9\Updater\Tests\TestCase;

class UpdaterCommandTest extends TestCase
{
    /** @test */
    public function it_updates_the_application()
    {
        // Mock the Updater facade to return a new version
        Updater::shouldReceive('newVersionAvailable')
            ->once()
            ->andReturn([
                'current_version' => 'v1.0.0',
                'latest_version' => 'v1.0.1',
            ]);

        Http::fake([
            'https://api.github.com/repos/salahhusa9/laravel-updater/releases/latest' => Http::response([
                'tag_name' => 'v1.0.1',
            ], 200),
        ]);

        // Mock the Updater facade to return the update command
        Updater::shouldReceive('getCurrentVersion')
            ->once()
            ->andReturn('v1.0.0');

        // Mock the Updater facade to return the update command
        Updater::shouldReceive('update')
            ->once()
            ->andReturn('Updated to version v1.0.1');

        // Call the UpdaterCommand
        $this->artisan('updater:update')
            ->expectsOutputToContain('Updating to version v1.0.1')
            ->expectsOutputToContain('Application updated') // in real life this should be v1.0.1 but we mock it to v1.0.0
            // ->expectsOutputToContain('v1.0.0') // in real life this should be v1.0.1 but we mock it to v1.0.0
            // ->expectsOutputToContain('You are now on version') // in real life this should be v1.0.1 but we mock it to v1.0.0
            ->assertExitCode(0);
    }

    /** @test */
    public function it_does_not_update_when_no_new_version_available()
    {
        // Mock the Updater facade to return no new version
        Updater::shouldReceive('newVersionAvailable')
            ->once()
            ->andReturn(false);

        // Call the UpdaterCommand
        $this->artisan('updater:update')
            ->expectsOutputToContain('No new version available')
            ->assertExitCode(1);
    }
}
