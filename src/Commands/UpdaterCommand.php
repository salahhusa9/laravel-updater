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

        $this->components->twoColumnDetail('Application updated', Updater::getCurrentVersion());

        $this->components->line('Thank you for using this package! ❤️');
        $this->components->line('Consider supporting my work: https://github.com/sponsors/salahhusa9');

        return self::SUCCESS;
    }
}
