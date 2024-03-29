<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\ArtisanCallRouteClearPipe;
use Salahhusa9\Updater\Tests\TestCase;

class ArtisanCallRouteClearPipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            '*' => Process::result('route:clear'),
        ]);

        $messages = [
            'Start clearing route cache',
            'Route cache cleared!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(ArtisanCallRouteClearPipe::class)->handle($content, $next);
    }
}
