<?php

namespace App\Runner\Job;

use App\Runner\Task\Database\DoctrineTransactionTask;
use App\Runner\Task\Database\PersistContributeTask;
use App\Runner\Task\Database\PersistSitesFromTmpDraftsTask;
use App\Runner\Task\Database\Raw\CompareShpAndSpreadsheetsEntriesTask;
use App\Runner\Task\Database\Raw\InsertDraftAndShpIntoTmpDraftTask;
use App\Runner\Task\Database\ValidateTmpDraftEntriesTaskToSpreadsheet;
use App\Runner\Task\Process\ImportShpToTmpTableTask;
use App\Runner\Task\Spreadsheet\GetContributeFromSpreadsheetMetadataTask;
use App\Runner\Task\Spreadsheet\ImportPublishedSitesSpreadsheetToTmpTableTask;
use App\Runner\Task\ValidatorTrait;
use Bnza\JobManagerBundle\Runner\Task\FileSystem\RenameTask;
use Bnza\JobManagerBundle\Runner\Task\Zip\ZipExtractToTask;

class FullImportPublishedSitesZipShapefileJob extends AbstractImportPublishedSitesZipShapefileJob
{
    use ValidatorTrait;

    const KEY_IS_DRAFT_VALID = 'is-draft-valid';

    public function getName(): string
    {
        return 'app:job:import:full-sites-zip';
    }

    public function getDescription(): string
    {
        return 'Importing published sites zip file into to "public".site"';
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
            [
                'class' => ValidateTmpDraftEntriesTaskToSpreadsheet::class,
                'parameters' => [
                    ['setValidator', 'getValidator'],
                    ['setEntityManager', 'getEntityManager'],
                    ['setSpreadSheetPath', 'getSpreadSheetPath'],
                    ['setContribute', 'getContribute'],
                ],
                'setters' => [
                    ['setDraftValid', 'isDraftValid'],
                ],
            ],
            [
                'class' => PersistSitesFromTmpDraftsTask::class,
                'condition' => 'isDraftValid',
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                    ['setContribute', 'getContribute'],
                ],
            ],
        ];
    }

    public function isDraftValid(bool $throw = true): string
    {
        return $this->getParameter(self::KEY_IS_DRAFT_VALID, $throw);
    }

    public function setDraftValid(bool $isValid)
    {
        return $this->getParameters()->set(self::KEY_IS_DRAFT_VALID, $isValid);
    }
}
