---
title: Configuring
description: Learn how to configure the package.
---

## Quick start

you need to config environment variables:

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

## Maintenance Mode

you can enable maintenance mode before update and disable it after update:

```javascript
'maintenance_mode' => true,
'maintenance_mode_secret' => env('MAINTENANCE_MODE_SECRET', false),
```

## Migrations

you can run migrations after update:

```javascript
'migrate' => false,
```

## Seeders

you can run seeders after update:

```javascript
'seeders' => [
    '\Database\Seeders\DatabaseSeeder::class',
],
```

## Cache Clear

you can run `php artisan cache:clear` after update:

```javascript
'cache:clear' => false,
```

## View Clear

you can run `php artisan view:clear` after update:

```javascript
'view:clear' => false,
```

## Config Clear

you can run `php artisan config:clear` after update:

```javascript
'config:clear' => false,
```

## Route Clear

you can run `php artisan route:clear` after update:

```javascript
'route:clear' => false,
```

## Optimize

you can run `php artisan optimize` after update:

```javascript
'optimize' => false,
```

## Pipelines

you can run pipelines before update:

```javascript
'before_update_pipelines' => [
    // you can add your own pipelines here
],
```

you can run pipelines after update:

```javascript

'after_update_pipelines' => [
    // you can add your own pipelines here
],
```
for more information about pipelines, see [Run Code before or after update](/docs/run-code-before-or-after-update).


