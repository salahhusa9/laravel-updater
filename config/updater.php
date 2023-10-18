<?php

// config for Salahhusa9/Updater
return [
    'github_token' => env('GITHUB_TOKEN'),
    'repository_source' => \Salahhusa9\Updater\RepositorySource\GithubRepository::class,
    'github_username' => env('GITHUB_USERNAME'),
    'github_repository' => env('GITHUB_REPOSITORY'),
];
