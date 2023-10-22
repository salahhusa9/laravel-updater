<?php

namespace Salahhusa9\Updater\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewVersionAvailable
{
    use Dispatchable, SerializesModels;

    public $currentVersion;

    public $newVersion;

    public function __construct($currentVersion, $newVersion)
    {
        $this->currentVersion = $currentVersion;
        $this->newVersion = $newVersion;
    }
}
