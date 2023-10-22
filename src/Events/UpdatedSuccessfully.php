<?php

namespace Salahhusa9\Updater\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

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



