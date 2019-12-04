<?php

namespace App\Runner\Job;

abstract class AbstractImportRemoteSensingSitesZipShapefileJob extends AbstractImportSitesZipShapefileJob
{
    const KEY_TXT_META_PATH = 'txt-meta-path';

    protected function getMetadataFilePathString(): string
    {
        $name = $this->getShapefileName();
        $path = '';
        foreach (new \DirectoryIterator($this->getWorkDir()) as $item) {
            if ($item->isFile()) {
                if (
                    $item->getExtension() === 'txt'
                    && $item->getBasename(".{$item->getExtension()}") === $name.".metadata"
                ) {
                    $path = $this->getWorkDir().DIRECTORY_SEPARATOR.$item->getBasename();
                    break;
                }
            }
        }
        return $path;
    }

    protected function getTextMetadataFilePath()
    {
        if (!$this->getParameters()->has(self::KEY_TXT_META_PATH)) {
            $path = $this->getMetadataFilePathString();
            if (!$path) {
                throw new \RuntimeException("No metadata txt file found");
            }
            $this->getParameters()->set(self::KEY_TXT_META_PATH, $path);
        }

        return $this->getParameter(self::KEY_TXT_META_PATH);
    }

    protected function hasTextMetadataFilePath(): bool
    {
        return $this->getParameters()->has(self::KEY_TXT_META_PATH) || (bool) $this->getMetadataFilePathString();
    }

}
