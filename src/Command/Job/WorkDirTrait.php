<?php

namespace App\Command\Job;

use Bnza\JobManagerBundle\Runner\Job\JobInterface;

trait WorkDirTrait
{
    abstract public function getJob(): JobInterface;

    /**
     * @var string
     */
    protected $baseWorkDir = '';

    /**
     * @return string
     */
    public function getBaseWorkDir(): string
    {
        return $this->baseWorkDir;
    }

    /**
     * @param string $workDir
     */
    public function setBaseWorkDir(string $workDir): void
    {
        $this->baseWorkDir = $workDir;
    }

    public function getWorkDir(): string
    {
        return $this->getBaseWorkDir().DIRECTORY_SEPARATOR.$this->getJob()->getId();
    }
}
