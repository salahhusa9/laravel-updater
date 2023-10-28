<?php

namespace Salahhusa9\Updater\Commands;

use Illuminate\Console\Command;
use Salahhusa9\Updater\Events\NewVersionAvailable;
use Salahhusa9\Updater\Facades\Updater;

class CheckCommand extends Command
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

        $this->info('New version available: '.$newVersionAvailable['latest_version']);

        event(new NewVersionAvailable($newVersionAvailable['current_version'], $newVersionAvailable['latest_version']));

        return self::SUCCESS;
    }
}
