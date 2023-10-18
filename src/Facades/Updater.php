<?php

namespace Salahhusa9\Updater\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Salahhusa9\Updater\Updater
 */
class Updater extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Salahhusa9\Updater\Updater::class;
    }
}
