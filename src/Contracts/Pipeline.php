<?php

namespace Salahhusa9\Updater\Contracts;

interface Pipeline
{
    public function handle($content, \Closure $next);
}
