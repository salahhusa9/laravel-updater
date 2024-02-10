<?php

namespace Salahhusa9\Updater\Tests;

use Illuminate\Support\Facades\Event;
use Salahhusa9\Updater\Commands\CheckCommand;
use Salahhusa9\Updater\Events\NewVersionAvailable;
use Salahhusa9\Updater\Facades\Updater;

class CheckCommandTest extends TestCase
{
    /** @test */
    public function it_does_not_show_any_message_if_no_new_version_is_available()
    {
        Updater::shouldReceive('newVersionAvailable')->once()->andReturn(false);

        $this->artisan('updater:check')
            ->expectsOutputToContain('No new version available')
            ->assertExitCode(CheckCommand::SUCCESS);
    }

    /** @test */
    public function it_shows_a_message_if_a_new_version_is_available()
    {
        Updater::shouldReceive('newVersionAvailable')->once()->andReturn([
            'current_version' => '1.0.0',
            'latest_version' => '1.1.0',
        ]);

        $this->artisan('updater:check')
            ->expectsOutputToContain('New version available: 1.1.0')
            ->assertExitCode(CheckCommand::SUCCESS);
    }

    /** @test */
    public function it_fires_a_new_version_available_event_if_a_new_version_is_available()
    {
        Event::fake();

        Updater::shouldReceive('newVersionAvailable')->once()->andReturn([
            'current_version' => '1.0.0',
            'latest_version' => '1.1.0',
        ]);

        $this->artisan('updater:check')
            ->expectsOutputToContain('New version available: 1.1.0');

        Event::assertDispatched(NewVersionAvailable::class, function ($event) {
            return $event->currentVersion === '1.0.0' && $event->newVersion === '1.1.0';
        });
    }
}
