<?php

use Illuminate\Support\Facades\Process;
use Salahhusa9\Updater\Tests\TestCase;

class GitTest extends TestCase
{
    public function test_get_current_commit(): void
    {
        Process::fake([
            'git log --pretty="%h" -n1 HEAD' => Process::result('commit-hash'),
        ]);

        // change config git_path to git, because git path changed between windows and linux
        config()->set('updater.git_path', 'git');

        $this->assertEquals('commit-hash', Salahhusa9\Updater\Helpers\Git::getCurrentCommit());
    }

    public function test_get_current_commit_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git log --pretty="%h" -n1 HEAD' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        // change config git_path to git, because git path changed between windows and linux
        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::getCurrentCommit();
    }

    public function test_get_current_branch(): void
    {
        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => Process::result('branch-name'),
        ]);

        // change config git_path to git, because git path changed between windows and linux
        config()->set('updater.git_path', 'git');

        $this->assertEquals('branch-name', Salahhusa9\Updater\Helpers\Git::getCurrentBranch());
    }

    public function test_get_current_branch_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git rev-parse --abbrev-ref HEAD' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        // change config git_path to git, because git path changed between windows and linux
        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::getCurrentBranch();
    }

    public function test_get_current_tag(): void
    {
        Process::fake([
            'git describe --tags --abbrev=0' => Process::result('tag-name'),
        ]);

        // change config git_path to git, because git path changed between windows and linux
        config()->set('updater.git_path', 'git');

        $this->assertEquals('tag-name', Salahhusa9\Updater\Helpers\Git::getCurrentTag());
    }

    public function test_get_current_tag_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git describe --tags --abbrev=0' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        // change config git_path to git, because git path changed between windows and linux
        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::getCurrentTag();
    }

    public function test_get_git_path(): void
    {
        config()->set('updater.git_path', 'git');

        $this->assertEquals('git', Salahhusa9\Updater\Helpers\Git::gitPath());
    }

    public function test_git_auth(): void
    {
        config()->set('updater.github_token', 'token');
        config()->set('updater.github_username', 'username');
        config()->set('updater.github_repository', 'repository');

        Process::fake([
            'git remote set-url origin https://'.config('updater.github_username').':'.config('updater.github_token').'@github.com/'.config('updater.github_username').'/'.config('updater.github_repository').'.git' => Process::result(''),
        ]);

        config()->set('updater.git_path', 'git');

        $this->assertEquals('', Salahhusa9\Updater\Helpers\Git::auth());
    }

    public function test_git_auth_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git remote set-url origin https://'.config('updater.github_username').':'.config('updater.github_token').'@github.com/'.config('updater.github_username').'/'.config('updater.github_repository').'.git' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::auth();
    }

    public function test_git_pull(): void
    {
        Process::fake([
            'git pull' => Process::result(''),
        ]);

        config()->set('updater.git_path', 'git');

        $this->assertEquals('', Salahhusa9\Updater\Helpers\Git::pull());
    }

    public function test_git_pull_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git pull' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::pull();
    }

    public function test_git_checkout(): void
    {
        Process::fake([
            'git checkout branch-name' => Process::result(''),
        ]);

        config()->set('updater.git_path', 'git');

        $this->assertEquals('', Salahhusa9\Updater\Helpers\Git::checkout('branch-name'));
    }

    public function test_git_checkout_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git checkout branch-name' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::checkout('branch-name');
    }

    public function test_git_fetch(): void
    {
        Process::fake([
            'git fetch' => Process::result(''),
        ]);

        config()->set('updater.git_path', 'git');

        $this->assertEquals('', Salahhusa9\Updater\Helpers\Git::fetch());
    }

    public function test_git_fetch_failed(): void
    {
        $this->expectException(Salahhusa9\Updater\Exceptions\GitFailedException::class);
        $this->expectExceptionMessage('Test error output');

        Process::fake([
            'git fetch' => Process::result(
                output: 'Test output',
                errorOutput: 'Test error output',
                exitCode: 1,
            ),
        ]);

        config()->set('updater.git_path', 'git');

        Salahhusa9\Updater\Helpers\Git::fetch();
    }
}
