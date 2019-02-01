<?php

namespace App\Runner\Job;


use App\Entity\ContributeEntity;
use App\Runner\Task\Database\PersistContributeTask;
use App\Runner\Task\Database\Raw\CompareShpAndSpreadsheetsEntriesTask;
use App\Runner\Task\Database\Raw\InsertDraftAndShpIntoTmpDraftTask;
use App\Runner\Task\Process\ImportShpToTmpTableTask;
use App\Runner\Task\Spreadsheet\GetContributeFromSpreadsheetMetadataTask;
use App\Runner\Task\Spreadsheet\ImportPublishedSitesSpreadsheetToTmpTableTask;
use Bnza\JobManagerBundle\Runner\Job\WorkDirTrait;
use Bnza\JobManagerBundle\Runner\Task\FileSystem\RenameTask;
use Bnza\JobManagerBundle\Runner\Task\Zip\ZipExtractToTask;
class ImportPublishedSitesZipShapefileJob extends AbstractDatabaseJob
{
    const KEY_ZIP_PATH = 'zip-path';
    const KEY_ZIP_NAME = 'zip-name';
    const KEY_CONTRIBUTE = 'contribute';
    const KEY_XLS_PATH = 'xls-path';

    use WorkDirTrait;

    public function getName(): string
    {
        return 'app:job:import:sites-zip';
    }

    public function getZipShapefilePath(bool $throw = true):string
    {
        return $this->getParameter(self::KEY_ZIP_PATH, $throw);
    }

    public function setZipShapefilePath(string $path)
    {
        return $this->getParameters()->set(self::KEY_ZIP_PATH, $path);
    }

    public function setShapefileName(string $name)
    {
        return $this->getParameters()->set(self::KEY_ZIP_NAME, $name);
    }

    public function getShapefileName()
    {
        if (!$this->getParameters()->has(self::KEY_ZIP_NAME)) {
            foreach (new \DirectoryIterator($this->getWorkDir()) as $item ) {
                if ($item->isFile()) {
                    if ($item->getExtension() === 'shp') {
                        $this->getParameters()->set(self::KEY_ZIP_NAME, $item->getBasename('.shp'));
                    }
                }
            }
        }
        return $this->getParameter(self::KEY_ZIP_NAME);
    }

    protected function getSpreadSheetPath()
    {
        if (!$this->getParameters()->has(self::KEY_XLS_PATH)) {
            $name = $this->getShapefileName();
            $path = '';
            foreach (new \DirectoryIterator($this->getWorkDir()) as $item ) {
                if ($item->isFile()) {
                    if (
                        \in_array($item->getExtension(), ['xls','xlsx','ods','csv'])
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

    public function getSteps(): iterable
    {
        return [
            [
                'class' => PersistContributeTask::class,
                'condition' => 'hasContribute',
                'parameters' => [
                    ['setContribute', 'getContribute'],
                    ['setEntityManager', 'getEntityManager']
                ],
            ],
            [
                'class' => RenameTask::class,
                'arguments' => [
                    [$this, 'getZipShapefilePath'],
                    [$this, 'getWorkDir']
                ],
                'setters' => [
                    [
                        'setZipShapefilePath',
                        [
                            'getTarget',
                            [$this, 'getZipShapefilePath'],
                        ]
                    ]
                ]
            ],
            [
                'class' => ZipExtractToTask::class,
                'arguments' => [
                    [$this, 'getZipShapefilePath'],
                    [$this, 'getWorkDir']
                ],
            ],
            [
                'class' => GetContributeFromSpreadsheetMetadataTask::class,
                'condition' => 'hasContribute',
                'negateCondition' => true,
                'parameters' => [
                    ['setSpreadSheetPath', 'getSpreadSheetPath']
                ],
                'setters' => [
                    ['setContribute', 'getContribute']
                ]
            ],
            [
                'class' => PersistContributeTask::class,
                'parameters' => [
                    ['setContribute', 'getContribute'],
                    ['setEntityManager', 'getEntityManager']
                ],
            ],
            [
                'class' => ImportShpToTmpTableTask::class,
                'parameters' => [
                    ['setSource', 'getShapefilePath'],
                    ['setEntityManager', 'getEntityManager']
                ],
            ],
            [
                'class' => ImportPublishedSitesSpreadsheetToTmpTableTask::class,
                'parameters' => [
                    ['setSpreadSheetPath', 'getSpreadSheetPath'],
                    ['setEntityManager', 'getEntityManager']
                ],
            ],
            [
                'class' => CompareShpAndSpreadsheetsEntriesTask::class,
                'parameters' => [
                    ['setEntityManager', 'getEntityManager']
                ],
            ],
            [
                'class' => InsertDraftAndShpIntoTmpDraftTask::class,
                'parameters' => [
                    ['setEntityManager', 'getEntityManager']
                ],
            ],
        ];
    }
}
