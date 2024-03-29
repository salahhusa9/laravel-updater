<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\ArtisanCallOptimizePipe;
use Salahhusa9\Updater\Tests\TestCase;

class ArtisanCallOptimizePipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            '*' => Process::result('optimize'),
        ]);

        $messages = [
            'Start optimizing',
            'Optimized!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(ArtisanCallOptimizePipe::class)->handle($content, $next);
    }
}
