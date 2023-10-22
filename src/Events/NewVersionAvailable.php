<?php

namespace Salahhusa9\Updater\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

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
