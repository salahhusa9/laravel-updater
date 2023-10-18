<?php

use Salahhusa9\Updater\Helpers\Git;

it('can test', function () {

    info([
        'Git::getCurrentBranch();' => Git::getCurrentBranch(),
    ]);

    expect(true)->toBeTrue();
});
