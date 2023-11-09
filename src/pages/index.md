---
title: Getting started
pageTitle: Laravel Updater - Getting started
description: Update your Laravel application to the latest version with a single command.
---

Learn how to get Laravel Updater set up in your project in under thirty minutes or it's free. {% .lead %}

{% quick-links %}

{% quick-link title="Installation" icon="installation" href="#installing" description="Step-by-step guides to setting up your system and installing the package." /%}

{% quick-link title="Customisation and Advance Use" icon="presets" href="/" description="Learn how the internals work and contribute." /%}

{% /quick-links %}

---

## Quick start

This is a useful package for update your Laravel application, and it can help simplify the process of update your application.

```shell
// From
git pull
php artisan migrate
php arinsan db:seed --class=DatabaseSeeder
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize
// To
php artisan updater:update
```


### Installing

This is a useful package for building menus in your Laravel application, and it can help simplify the process of creating and managing menus in your application.


```shell
composer require salahhusa9/laravel-updater
```

You can publish the config file with:

```shell
php artisan vendor:publish --tag="laravel-updater-config"
```

### Configuring

This the default config file:

```javascript
<?php

// config for Salahhusa9/Updater
return [

    'git_path' => null,

    'repository_source' => \Salahhusa9\Updater\RepositorySource\GithubRepository::class,
    'github_token' => env('GITHUB_TOKEN'),
    'github_username' => env('GITHUB_USERNAME'),
    'github_repository' => env('GITHUB_REPOSITORY'),

    'github_timeout' => 100,

    'maintenance_mode' => true,
    'maintenance_mode_secret' => env('MAINTENANCE_MODE_SECRET', false),

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
```

You need olso add environment variables:

```env
GITHUB_TOKEN=
GITHUB_USERNAME=
GITHUB_REPOSITORY=
```
Example:

```env
GITHUB_TOKEN=ghp_1234567890
GITHUB_USERNAME=salahhusa9
GITHUB_REPOSITORY=laravel-updater
```

{% callout title="what is GITHUB_TOKEN" %}
GITHUB_TOKEN is a personal access token that you can create in your GitHub account. You can find more information about how to create a personal access token [here](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing)

{% /callout %}

---

## Basic usage

After Installing package and add environment variables you can start use it.

### Your first update

you need understand how it's work. versions it's load from github releases and you can add your own releases.
so you need create a release in your github repository and add a tag to it.

[How Managing releases/versioning your projects (github)](https://docs.github.com/en/repositories/releasing-projects-on-github/managing-releases-in-a-repository)

after create your first release you can run this command to update your application:

```bash
php artisan updater:update
```

### After update

you can run migration, seeders and cache...  after update by change config file.

```javascript

// run php artisan migrate after update?
'migrate' => true,

// run seeders after update?
'seeders' => [
    // '\Database\Seeders\DatabaseSeeder::class',
],

// run php artisan cache:clear after update?
'cache:clear' => true,

// run php artisan view:clear after update?
'view:clear' => true,

// run php artisan config:clear after update?
'config:clear' => true,

// run php artisan route:clear after update?
'route:clear' => true,

// run php artisan optimize after update?
'optimize' => true,
```

there is olso pipelines after update:

```javascript
'after_update_pipelines' => [
    // you can add your own pipelines here
],
```

you can see how it's work in section of [pipelines](/docs/how-it's-work).

### Before update

by defult if is `maintenance_mode` is true, it's will be enable before update and disable after update.

you can run pipelines before update:

```javascript
'before_update_pipelines' => [
    // you can add your own pipelines here
],
```

you can see how it's work in section of [advance use](/pipelines).

## Getting help

If you're having trouble getting Laravel Updater up and running, help is just a click away.

### Submit an issue

If you've found a bug or want to suggest a new feature, you can [submit an issue](https://github.com/salahhusa9/laravel-updater/issues)

### Join the community

If you need help, want to share an idea, or just want to chat about menus, you can join the [twitter](https://twitter.com/SBendyab).

### Hire me

If you need help with your Laravel application, you can [hire me](mailto:salahhusa9@gmail.com).