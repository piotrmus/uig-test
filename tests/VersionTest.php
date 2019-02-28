<?php
/**
 * Created by PhpStorm.
 * User: Piotr Musial
 * Date: 2019-02-28
 * Time: 18:54
 */

namespace Test;


use App\Version\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    public function testCreateVersion()
    {
        $version = new Version("2.1.3B");
        $this->assertInstanceOf(Version::class, $version);
        $this->assertEquals($version->getLevelDeep(), 3);
        $this->assertEquals($version->getTestLevel(), Version::TEST_BETA);
        $this->assertEquals($version->getLevel(1), 2);
        $this->assertEquals($version->getLevel(3), 3);
    }

    public function testVersionCompare()
    {
        $this->assertEquals((new Version("1.0.0"))->compare(new Version("1.2.3")), 1);
        $this->assertEquals((new Version("1.2.3"))->compare(new Version("1.2.3a")), 0);
        $this->assertEquals((new Version("1b"))->compare(new Version("1.2.3a")), 1);
    }

}