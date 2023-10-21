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
        $this->comment('start');

        Updater::update();

        $this->info('Done');

        return self::SUCCESS;
    }
}
