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
            $this->error('No new version available');

            return self::FAILURE;
        }

        $this->comment('Updating to version '.$newVersionAvailable['new_version']);

        Updater::update();

        $this->info('Application updated! You are now on version '. Updater::getCurrentVersion().'!');

        return self::SUCCESS;
    }
}
