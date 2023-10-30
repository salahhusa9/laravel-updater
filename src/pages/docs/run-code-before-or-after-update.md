---
title: Run Code before or after update
description: Learn how to run code before or after update.
---

it's easy to run function before or after update, you just need to create a pipeline class and add it to the config file:

```javascript
// run after update?
'before_update_pipelines' => [
    // you can add your own pipelines here
],

// run after update?
'after_update_pipelines' => [
    // you can add your own pipelines here
],
```

Example of pipeline class:

```javascript

namespace App\Pipelines;

use Closure;
use Salahhusa9\Updater\Contracts\Pipeline;

class MyPipeline implements Pipeline
{
    public function handle($payload, Closure $next)
    {
        // do something

        $next($payload);
    }
}
``` 
Must be implement `Salahhusa9\Updater\Contracts\Pipeline` interface,
and payload is array of data:

```javascript
[
    'current_version' => 'v1.0.0',
    'new_version' => 'v1.0.1',
    'output' => // callback function to output data,
]
```
Output function is callback function to output data to console:

```javascript
public function handle($payload, Closure $next)
{
    $payload['output']('hello world');
    // or
    if (is_callable($content['output'])) {
        call_user_func($content['output'], 'hello world');
    }

    // do something

    $next($payload);
}
```

{% callout type="warning" title="Don't do it" %}
Please don't run in pipeline class this commands:
- composer install
- composer update

generally don't run any command that link to composer.

{% /callout %}


you can see how it's work in section of [pipelines](/docs/how-it's-work).
