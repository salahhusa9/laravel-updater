<?php

use Salahhusa9\Updater\Helpers\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testIsVersionReturnsTrueForValidVersion()
    {
        $helper = new Helper();

        $this->assertEquals($helper->isVersion('v1.2.3'), 1);
    }

    public function testIsVersionReturnsFalseForInvalidVersion()
    {
        $helper = new Helper();

        $this->assertEqualsCanonicalizing($helper->isVersion('invalid-version'), 0);
    }
}
