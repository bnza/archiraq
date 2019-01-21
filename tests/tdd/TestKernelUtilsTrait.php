<?php

namespace App\Tests;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Trait TestKernelUtilsTrait must be used in \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase subclasses.
 */
trait TestKernelUtilsTrait
{
    protected function getKernel(): KernelInterface
    {
        if (!self::$kernel) {
            self::$kernel = self::bootKernel();
        }

        return self::$kernel;
    }

    protected function getRootDir(): string
    {
        return $this->getKernel()->getProjectDir();
    }

    protected function getAbsolutePath(string $relativePath)
    {
        $relativePath = DIRECTORY_SEPARATOR === substr($relativePath, 0, 1)
            ?: DIRECTORY_SEPARATOR.$relativePath;

        return $this->getRootDir().DIRECTORY_SEPARATOR.$relativePath;
    }
}
