<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\SeedersPipe;
use Salahhusa9\Updater\Tests\TestCase;

class SeedersPipeTest extends TestCase
{
    public function test_run_handle()
    {
        $messages = [
            'Seeding...',
            'Seeded!',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        config()->set('updater.seeders', [
            
        ]);


        app()->make(SeedersPipe::class)->handle($content, $next);
    }
}
