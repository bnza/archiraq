<?php

namespace App\Tests\Functional;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Trait TestKernelUtilsTrait must be used in \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase subclasses.
 */
trait TestKernelUtilsTrait
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected static function getKernel(): KernelInterface
    {
        if (!self::$kernel) {
            self::$kernel = self::bootKernel();
        }

        return self::$kernel;
    }

    protected static function getContainer(): ContainerInterface
    {
        if (!self::$container) {
            self::getKernel()->getContainer();
        }

        return self::$container;
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

    protected function getValidator(): ValidatorInterface
    {
        if (!$this->validator) {
/*            if (!self::$container) {
                self::getKernel()->getContainer();
            }*/
            $this->validator = self::getContainer()->get(ValidatorInterface::class);
        }

        return $this->validator;
    }
}
