<?php

namespace Salahhusa9\Updater\Commands;

use Illuminate\Console\Command;
use Salahhusa9\Updater\Facades\Updater;

class UpdaterCommand extends Command
{
    public $signature = 'updater:update';

    public $description = 'Update the application';

    public function handle(): int
    {
        $newVersionAvailable = Updater::newVersionAvailable();
        if (! is_array($newVersionAvailable)) {
            $this->components->error('No new version available');

            return self::FAILURE;
        }

        $this->components->info('Updating to version '.$newVersionAvailable['latest_version']);

        Updater::update(output: function ($message) {
            $this->components->task($message);
        });

        $this->components->twoColumnDetails('Application updated', 'You are now on version '.Updater::getCurrentVersion());

        return self::SUCCESS;
    }
}
