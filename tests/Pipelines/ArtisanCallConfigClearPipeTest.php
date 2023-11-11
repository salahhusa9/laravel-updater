<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\ArtisanCallConfigClearPipe;
use Salahhusa9\Updater\Tests\TestCase;

class ArtisanCallConfigClearPipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            '*' => Process::result('config:clear'),
        ]);

        $messages = [
            'Clearing config cache...',
            'Config cache cleared!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(ArtisanCallConfigClearPipe::class)->handle($content, $next);
    }
}
