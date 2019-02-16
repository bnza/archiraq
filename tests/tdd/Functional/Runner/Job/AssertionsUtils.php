<?php

namespace App\Tests\Functional\Runner\Job;

abstract class AssertionsUtils extends \PHPUnit\Framework\TestCase
{
    protected function assertDirIsEmpty(string $dir)
    {
        $this->assertFileExists($dir);
        $this->assertTrue(\is_dir($dir), "\"$dir\" is a directory");
        $this->assertEquals(0, $this->countFiles($dir), "Directory \"$dir\" is empty");
    }
}
