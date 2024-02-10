<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\ArtisanCallMigratePipe;
use Salahhusa9\Updater\Tests\TestCase;

class ArtisanCallMigratePipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            '*' => Process::result('migrate'),
        ]);

        $messages = [
            'Start migrating',
            'Migrated!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(ArtisanCallMigratePipe::class)->handle($content, $next);
    }
}
