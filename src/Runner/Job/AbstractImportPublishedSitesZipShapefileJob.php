<?php

namespace App\Runner\Job;

abstract class AbstractImportPublishedSitesZipShapefileJob extends AbstractImportRemoteSensingSitesZipShapefileJob
{
    const KEY_XLS_PATH = 'xls-path';

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

    protected function shouldUseTextMetadataContribute(): bool
    {
        return !$this->hasContribute() && $this->hasTextMetadataFilePath();
    }
}
