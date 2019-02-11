<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Trait TestKernelUtilsTrait must be used in \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase subclasses.
 */
trait TestKernelUtilsTrait
{
    protected static function getKernel(): KernelInterface
    {
        if (!self::$kernel) {
            self::$kernel = self::bootKernel();
        }

        return self::$kernel;
    }

    protected static function getRootDir(): string
    {
        return self::getKernel()->getProjectDir();
    }

    protected static function getAbsolutePath(string $relativePath)
    {
        $relativePath = DIRECTORY_SEPARATOR === substr($relativePath, 0, 1)
            ?: DIRECTORY_SEPARATOR.$relativePath;

        return self::getRootDir().DIRECTORY_SEPARATOR.$relativePath;
    }

    protected function getAssetsDir(): string
    {
        return $this->getRootDir().DIRECTORY_SEPARATOR.'tests/assets';
    }
}
