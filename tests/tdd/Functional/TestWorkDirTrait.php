<?php

namespace App\Tests\Functional;

use Symfony\Component\Filesystem\Filesystem;

trait TestWorkDirTrait
{
    /**
     * @var string
     */
    private $baseTestDir = '';

    /**
     * @var string
     */
    private $baseTestOmDir = '';

    /**
     * @var string
     */
    private $baseTestWorkDir = '';

    /**
     * @var Filesystem
     */
    private $fs;

    protected function getFilesystem(): Filesystem
    {
        if (!$this->fs) {
            $this->fs = new Filesystem();
        }
        return $this->fs;
    }

    protected function getTestDir(): string
    {
        if (!$this->baseTestDir) {
            $this->baseTestDir = \sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'bnza' . DIRECTORY_SEPARATOR . 'test';
        }
        return $this->baseTestDir;
    }

    protected function getBaseWorkDir(): string
    {
        if (!$this->baseTestWorkDir) {
            $this->baseTestWorkDir = $this->getTestDir() . DIRECTORY_SEPARATOR . 'works';
        }
        return $this->baseTestWorkDir;
    }

    protected function getWorkDir(string $jobId): string
    {
        return $this->getBaseWorkDir().DIRECTORY_SEPARATOR.$jobId;
    }

    protected function getBaseOmDir(): string
    {
        if (!$this->baseTestOmDir) {
            $this->baseTestOmDir = $this->getTestDir() . DIRECTORY_SEPARATOR . 'om';
        }
        return $this->baseTestOmDir;
    }

    protected function setUpBaseOmDir()
    {
        $this->tearDownDir($this->getBaseOmDir());

        \mkdir($this->getBaseOmDir(), 0700, true);
    }

    protected function setUpBaseWorkDir()
    {
        $this->tearDownDir($this->getBaseWorkDir());

        \mkdir($this->getBaseWorkDir(), 0700, true);
    }

    protected function setUpWorkDir(string $id)
    {

        \mkdir($this->getBaseWorkDir().DIRECTORY_SEPARATOR.$id, 0700, true);
    }

    protected function setUpOmJobDir(string $id)
    {

        \mkdir($this->getBaseOmDir().DIRECTORY_SEPARATOR.$id, 0700, true);
    }

    protected function tearDownDir(string $dir)
    {
        $baseTestDir = $this->getTestDir();
        if (\substr($dir, 0, strlen($baseTestDir)) === $baseTestDir &&
            \file_exists($dir)) {
            $this->getFilesystem()->remove($dir);
        }
    }

    protected function countFiles(string $dir): int
    {
        $i = new \FilesystemIterator($dir, \FilesystemIterator::SKIP_DOTS);
        return \iterator_count($i);
    }

    /**
     * @param string $origin path is relative to tests/assets/
     * @param string $destination path is relative to $TMPDIR/bnza/test
     * @return string
     */
    protected function copyAssetToTempDir(string $origin, string $destination): string
    {
        $testDir = $this->getTestDir();
        if (!\file_exists($testDir)) {
            \mkdir($testDir, 0700, true);
        }

        $origin = $this->getAssetsDir().DIRECTORY_SEPARATOR.$origin;
        $destination = $testDir.DIRECTORY_SEPARATOR.$destination;
        $this->getFilesystem()->copy($origin, $destination);
        return $destination;
    }

    protected function getAssetsDir(): string
    {
        $dir = __DIR__;
        $path = realpath($dir.'/../../assets/');
        return $path;
    }
}
