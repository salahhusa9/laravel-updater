<?php

namespace Salahhusa9\Updater\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateFailed
{
    use Dispatchable, SerializesModels;

    public $pastVersion;

    public $newVersion;

    public $exception;

    public function __construct($pastVersion, $newVersion, $exception)
    {
        $this->pastVersion = $pastVersion;
        $this->newVersion = $newVersion;
        $this->exception = $exception;
    }
}
