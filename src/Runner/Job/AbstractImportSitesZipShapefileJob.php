<?php

namespace App\Runner\Job;

use App\Entity\ContributeEntity;
use Bnza\JobManagerBundle\Runner\Job\WorkDirTrait;

abstract class AbstractImportSitesZipShapefileJob extends AbstractDatabaseJob
{
    const KEY_ZIP_PATH_SOURCE = 'source-zip-path';
    const KEY_ZIP_NAME = 'zip-name';
    const KEY_CONTRIBUTE = 'contribute';
    const KEY_IS_DRAFT_VALID = 'is-draft-valid';

    use WorkDirTrait;
    use ContributeTrait;

    public function getSourceZipShapefilePath(bool $throw = true): string
    {
        return $this->getParameter(self::KEY_ZIP_PATH_SOURCE, $throw);
    }

    public function setSourceZipShapefilePath(string $path)
    {
        return $this->getParameters()->set(self::KEY_ZIP_PATH_SOURCE, $path);
    }

    public function getTargetZipShapefilePath(bool $throw = true): string
    {
        return $this->getWorkDir().DIRECTORY_SEPARATOR.basename($this->getParameter(self::KEY_ZIP_PATH_SOURCE, $throw));
    }

    public function setShapefileName(string $name)
    {
        return $this->getParameters()->set(self::KEY_ZIP_NAME, $name);
    }

    public function getShapefileName()
    {
        if (!$this->getParameters()->has(self::KEY_ZIP_NAME)) {
            $baseName = '';
            foreach (new \DirectoryIterator($this->getWorkDir()) as $item) {
                if ($item->isFile()) {
                    if ('shp' === $item->getExtension()) {
                        $baseName = $item->getBasename('.shp');
                        break;
                    }
                }
            }
            if (!$baseName) {
                throw new \RuntimeException('No shapefile found');
            }
            $this->getParameters()->set(self::KEY_ZIP_NAME, $item->getBasename('.shp'));
        }

        return $this->getParameter(self::KEY_ZIP_NAME);
    }

    public function getShapefilePath()
    {
        return $this->getWorkDir().DIRECTORY_SEPARATOR.$this->getShapefileName().'.shp';
    }

    public function hasContribute(): bool
    {
        return $this->getParameters()->has(self::KEY_CONTRIBUTE);
    }

    public function getContribute(bool $throw = true): ContributeEntity
    {
        return $this->getParameter(self::KEY_CONTRIBUTE, $throw);
    }

    public function setContribute(ContributeEntity $contribute)
    {
        return $this->getParameters()->set(self::KEY_CONTRIBUTE, $contribute);
    }

    public function isDraftValid(bool $throw = true): string
    {
        return $this->getParameter(self::KEY_IS_DRAFT_VALID, $throw);
    }

    public function setDraftValid(bool $isValid)
    {
        $isDraftValid = $this->getParameters()->has(self::KEY_IS_DRAFT_VALID) ? $this->isDraftValid() : true;
        return $this->getParameters()->set(self::KEY_IS_DRAFT_VALID, $isDraftValid && $isValid);
    }
}
