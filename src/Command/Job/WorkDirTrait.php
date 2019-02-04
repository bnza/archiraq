<?php

namespace App\Command\Job;


trait WorkDirTrait
{
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
}
