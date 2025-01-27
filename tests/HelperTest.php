<?php

use PHPUnit\Framework\TestCase;
use Salahhusa9\Updater\Helpers\Helper;

class HelperTest extends TestCase
{
    public function test_is_version_returns_true_for_valid_version()
    {
        $helper = new Helper;

        $this->assertEquals($helper->isVersion('v1.2.3'), 1);
    }

    public function test_is_version_returns_false_for_invalid_version()
    {
        $helper = new Helper;

        $this->assertEqualsCanonicalizing($helper->isVersion('invalid-version'), 0);
    }
}
