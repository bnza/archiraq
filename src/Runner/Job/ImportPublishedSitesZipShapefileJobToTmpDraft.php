<?php

namespace App\Runner\Job;

use App\Runner\Task\Database\DoctrineTransactionTask;
use App\Runner\Task\Database\PersistContributeTask;
use App\Runner\Task\Database\Raw\CompareShpAndSpreadsheetsEntriesTask;
use App\Runner\Task\Database\Raw\InsertDraftAndShpIntoTmpDraftTask;
use App\Runner\Task\Process\ImportShpToTmpTableTask;
use App\Runner\Task\Spreadsheet\GetContributeFromSpreadsheetMetadataTask;
use App\Runner\Task\Spreadsheet\ImportPublishedSitesSpreadsheetToTmpTableTask;
use Bnza\JobManagerBundle\Runner\Task\FileSystem\RenameTask;
use Bnza\JobManagerBundle\Runner\Task\Zip\ZipExtractToTask;

class ImportPublishedSitesZipShapefileJobToTmpDraft extends AbstractImportPublishedSitesZipShapefileJob
{

    public function getName(): string
    {
        return 'app:job:import:sites-zip-to-draft';
    }

    public function getDescription(): string
    {
        return 'Importing published sites zip file into "tmp"."draft" table' ;
    }

    public function getSteps(): iterable
    {
        return [
            [
                'class' => DoctrineTransactionTask::class,
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => PersistContributeTask::class,
                'condition' => 'hasContribute',
                'parameters' => [
                    ['setContribute', 'getContribute'],
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => RenameTask::class,
                'arguments' => [
                    [$this, 'getSourceZipShapefilePath'],
                    [$this, 'getWorkDir'],
                ],
            ],
            [
                'class' => ZipExtractToTask::class,
                'arguments' => [
                    [$this, 'getTargetZipShapefilePath'],
                    [$this, 'getWorkDir'],
                ],
            ],
            [
                'class' => GetContributeFromSpreadsheetMetadataTask::class,
                'condition' => 'hasContribute',
                'negateCondition' => true,
                'parameters' => [
                    ['setSpreadSheetPath', 'getSpreadSheetPath'],
                ],
                'setters' => [
                    ['setContribute', 'getContribute'],
                ],
            ],
            [
                'class' => PersistContributeTask::class,
                'parameters' => [
                    ['setContribute', 'getContribute'],
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => ImportShpToTmpTableTask::class,
                'parameters' => [
                    ['setSource', 'getShapefilePath'],
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => ImportPublishedSitesSpreadsheetToTmpTableTask::class,
                'parameters' => [
                    ['setContribute', 'getContribute'],
                    ['setSpreadSheetPath', 'getSpreadSheetPath'],
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => CompareShpAndSpreadsheetsEntriesTask::class,
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => InsertDraftAndShpIntoTmpDraftTask::class,
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
        ];
    }
}
