<?php

// config for Salahhusa9/Updater
return [

    'git_path' => null,

    'repository_source' => \Salahhusa9\Updater\RepositorySource\GithubRepository::class,
    'github_token' => env('GITHUB_TOKEN'),
    'github_username' => env('GITHUB_USERNAME'),
    'github_repository' => env('GITHUB_REPOSITORY'),

    'before_update_pipelines' => [
        // you can add your own pipelines here
    ],

    // run php artisan migrate after update?
    'migrate' => false,

    // run seeders after update?
    'seeders' => [
        // '\Database\Seeders\DatabaseSeeder::class',
    ],

    // run php artisan cache:clear after update?
    'cache:clear' => false,

    // run php artisan view:clear after update?
    'view:clear' => false,

    // run php artisan config:clear after update?
    'config:clear' => false,

    // run php artisan route:clear after update?
    'route:clear' => false,

    // run php artisan optimize after update?
    'optimize' => false,

    'after_update_pipelines' => [
        // you can add your own pipelines here
    ],

];
