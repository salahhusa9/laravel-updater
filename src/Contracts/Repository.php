<?php

namespace Salahhusa9\Updater\Contracts;

interface Repository
{
    public function getLatestVersion();

    public function getLatestVersionData();

    public function getVersions();

    public function getVersionsData();
}
