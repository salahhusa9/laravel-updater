<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Salahhusa9\Updater\Pipelines\SeedersPipe;
use Salahhusa9\Updater\Tests\TestCase;

class SeedersPipeTest extends TestCase
{
    public function test_run_handle()
    {
        $messages = [
            'Start seeding',
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
