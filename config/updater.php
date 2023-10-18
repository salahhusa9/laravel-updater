<?php

// config for Salahhusa9/Updater
return [

    'git_path' => null,

    'repository_source' => \Salahhusa9\Updater\RepositorySource\GithubRepository::class,
    'github_token' => env('GITHUB_TOKEN'),
    'github_username' => env('GITHUB_USERNAME'),
    'github_repository' => env('GITHUB_REPOSITORY'),

];
