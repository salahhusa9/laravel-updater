<?php

namespace Salahhusa9\Updater\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatedSuccessfully
{
    use Dispatchable, SerializesModels;

    public $pastVersion;

    public $newVersion;

    public function __construct($pastVersion, $newVersion)
    {
        $this->pastVersion = $pastVersion;
        $this->newVersion = $newVersion;
    }
}
