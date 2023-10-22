<?php

namespace Salahhusa9\Updater\Commands;

use Illuminate\Console\Command;
use Salahhusa9\Updater\Facades\Updater;

class UpdaterCommand extends Command
{
    public $signature = 'updater:check';

    public $description = 'Check for new versions';

    public function handle(): int
    {
        $newVersionAvailable = Updater::newVersionAvailable();
        if (! is_array($newVersionAvailable)) {
            $this->info('No new version available');

            return self::SUCCESS;
        }

        $this->info('New version available: '.$newVersionAvailable['new_version']);

        return self::SUCCESS;
    }
}
