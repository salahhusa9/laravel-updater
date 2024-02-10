<?php

namespace Salahhusa9\Updater\Tests\Pipelines;

use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Pipelines\GitPipe;
use Salahhusa9\Updater\Tests\TestCase;

class GitPipeTest extends TestCase
{
    public function test_run_handle()
    {
        Process::fake([
            '*' => Process::result('1.0.0'), // this for return $version in getCurrentVersion()
        ]);

        $messages = [
            'Start downloading version 1.0.0',
            'Checkout success',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
            'new_version' => '1.0.0',
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(GitPipe::class)->handle($content, $next);
    }

    public function test_run_handle_with_error()
    {
        $this->expectException(\Exception::class);

        Process::fake([
            '*' => Process::result('error'), // this for throw new \Exception('git checkout failed: '.$checkout); becouse $checkout = Git::checkout($version); return error
        ]);

        $messages = [
            'Start downloading version 1.0.0',
            'git checkout failed: error',
        ];

        $content = [
            'output' => function ($message) use ($messages) {
                $this->assertTrue(in_array($message, $messages));
            },
            'new_version' => '1.0.0',
        ];

        $next = function ($result) use ($content) {
            $this->assertEquals($result, $content);
        };

        app()->make(GitPipe::class)->handle($content, $next);
    }
}
