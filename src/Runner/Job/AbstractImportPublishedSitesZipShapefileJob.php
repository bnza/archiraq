<?php

namespace App\Runner\Job;

use App\Entity\ContributeEntity;
use Bnza\JobManagerBundle\Runner\Job\WorkDirTrait;

abstract class AbstractImportPublishedSitesZipShapefileJob extends AbstractDatabaseJob
{
    const KEY_ZIP_PATH_SOURCE = 'source-zip-path';
    const KEY_ZIP_NAME = 'zip-name';
    const KEY_CONTRIBUTE = 'contribute';
    const KEY_XLS_PATH = 'xls-path';

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

    protected function getSpreadSheetPath()
    {
        if (!$this->getParameters()->has(self::KEY_XLS_PATH)) {
            $name = $this->getShapefileName();
            $path = '';
            foreach (new \DirectoryIterator($this->getWorkDir()) as $item) {
                if ($item->isFile()) {
                    if (
                        \in_array($item->getExtension(), ['xls', 'xlsx', 'ods'])
                        && $item->getBasename(".{$item->getExtension()}") === $name
                    ) {
                        $path = $this->getWorkDir().DIRECTORY_SEPARATOR.$item->getBasename();
                        $this->getParameters()->set(self::KEY_XLS_PATH, $path);
                        break;
                    }
                }
            }
            if (!$path) {
                throw new \RuntimeException("No spreadsheets named $name.[xls|xlsx|ods|csv] found");
            }
        }

        return $this->getParameter(self::KEY_XLS_PATH);
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
}
