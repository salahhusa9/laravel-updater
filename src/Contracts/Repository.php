<?php

namespace Salahhusa9\Updater\Contracts;

interface Repository
{
    public function getLatestVersion(): string;

    public function getLatestVersionData(): \Illuminate\Support\Collection;

    public function getVersions(): array;

    public function getVersionsData(): \Illuminate\Support\Collection;
}
