<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\ArtisanCallViewClearPipe;
use Salahhusa9\Updater\Tests\TestCase;

class ArtisanCallViewClearPipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            'php artisan view:clear' => Process::result('view:clear'),
        ]);

        $messages = [
            'Clearing view cache...',
            'View cache cleared!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(ArtisanCallViewClearPipe::class)->handle($content, $next);
    }
}
