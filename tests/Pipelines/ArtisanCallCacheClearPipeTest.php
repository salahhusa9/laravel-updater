<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\ArtisanCallCacheClearPipe;
use Salahhusa9\Updater\Tests\TestCase;

class ArtisanCallCacheClearPipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            '*' => Process::result('cache:clear'),
        ]);

        $messages = [
            'Clearing cache...',
            'Cache cleared!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(ArtisanCallCacheClearPipe::class)->handle($content, $next);
    }
}
