<?php

namespace Salahhusa9\Updater\Commands;

use Illuminate\Console\Command;

class UpdaterCommand extends Command
{
    public $signature = 'laravel-updater';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
