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

Praesentium laudantium magni. Consequatur reiciendis aliquid nihil iusto ut in et. Quisquam ut et aliquid occaecati. Culpa veniam aut et voluptates amet perspiciatis. Qui exercitationem in qui. Vel qui dignissimos sit quae distinctio.

### Your first cache

Minima vel non iste debitis. Consequatur repudiandae et quod accusamus sit molestias consequatur aperiam. Et sequi ipsa eum voluptatibus ipsam. Et quisquam ut.

Qui quae esse aspernatur fugit possimus. Quam sed molestiae temporibus. Eum perferendis dignissimos provident ea et. Et repudiandae quasi accusamus consequatur dolore nobis. Quia reiciendis necessitatibus a blanditiis iste quia. Ut quis et amet praesentium sapiente.

Atque eos laudantium. Optio odit aspernatur consequuntur corporis soluta quidem sunt aut doloribus. Laudantium assumenda commodi.

### Clearing the cache

Vel aut velit sit dolor aut suscipit at veritatis voluptas. Laudantium tempore praesentium. Qui ut voluptatem.

Ea est autem fugiat velit esse a alias earum. Dolore non amet soluta eos libero est. Consequatur qui aliquam qui odit eligendi ut impedit illo dignissimos.

Ut dolore qui aut nam. Natus temporibus nisi voluptatum labore est ex error vel officia. Vero repellendus ut. Suscipit voluptate et placeat. Eius quo corporis ab et consequatur quisquam. Nihil officia facere dolorem occaecati alias deleniti deleniti in.

### Adding middleware

Officia nobis tempora maiores id iusto magni reprehenderit velit. Quae dolores inventore molestiae perspiciatis aut. Quis sequi officia quasi rem officiis officiis. Nesciunt ut cupiditate. Sunt aliquid explicabo enim ipsa eum recusandae. Vitae sunt eligendi et non beatae minima aut.

Harum perferendis aut qui quibusdam tempore laboriosam voluptatum qui sed. Amet error amet totam exercitationem aut corporis accusantium dolorum. Perspiciatis aut animi et. Sed unde error ut aut rerum.

Ut quo libero aperiam mollitia est repudiandae quaerat corrupti explicabo. Voluptas accusantium sed et doloribus voluptatem fugiat a mollitia. Numquam est magnam dolorem asperiores fugiat. Soluta et fuga amet alias temporibus quasi velit. Laudantium voluptatum perspiciatis doloribus quasi facere. Eveniet deleniti veniam et quia veritatis minus veniam perspiciatis.

---

## Getting help

Consequuntur et aut quisquam et qui consequatur eligendi. Necessitatibus dolorem sit. Excepturi cumque quibusdam soluta ullam rerum voluptatibus. Porro illo sequi consequatur nisi numquam nisi autem. Ut necessitatibus aut. Veniam ipsa voluptatem sed.

### Submit an issue

Inventore et aut minus ut voluptatem nihil commodi doloribus consequatur. Facilis perferendis nihil sit aut aspernatur iure ut dolores et. Aspernatur odit dignissimos. Aut qui est sint sint.

Facere aliquam qui. Dolorem officia ipsam adipisci qui molestiae. Error voluptatem reprehenderit ex.

Consequatur enim quia maiores aperiam et ipsum dicta. Quam ut sit facere sit quae. Eligendi veritatis aut ut veritatis iste ut adipisci illo.

### Join the community

Praesentium facilis iste aliquid quo quia a excepturi. Fuga reprehenderit illo sequi voluptatem voluptatem omnis. Id quia consequatur rerum consectetur eligendi et omnis. Voluptates iusto labore possimus provident praesentium id vel harum quisquam. Voluptatem provident corrupti.

Eum et ut. Qui facilis est ipsa. Non facere quia sequi commodi autem. Dicta autem sit sequi omnis impedit. Eligendi amet dolorum magnam repudiandae in a.

Molestiae iusto ut exercitationem dolorem unde iusto tempora atque nihil. Voluptatem velit facere laboriosam nobis ea. Consequatur rerum velit ipsum ipsam. Et qui saepe consequatur minima laborum tempore voluptatum et. Quia eveniet eaque sequi consequatur nihil eos.
