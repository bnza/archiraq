<?php

namespace App\Runner\Job;

use App\Runner\Task\Database\DoctrineTransactionTask;
use App\Runner\Task\Database\PersistContributeTask;
use App\Runner\Task\Database\PersistSitesFromTmpDraftTaskSQL;
use App\Runner\Task\Database\Raw\DisableMaterializedSiteUpdateTriggerTask;
use App\Runner\Task\Database\Raw\InsertRemoteSensingShpIntoTmpDraftTask;
use App\Runner\Task\Database\Raw\UpdateMaterializedSiteViewTask;
use App\Runner\Task\Database\ValidateTmpDraftEntriesTaskToCsv;
use App\Runner\Task\GetContributeMetadataFromTextFileTask;
use App\Runner\Task\Process\ImportShpToTmpTableTask;
use App\Runner\Task\ValidatorTrait;
use Bnza\JobManagerBundle\Runner\Task\FileSystem\RenameTask;
use Bnza\JobManagerBundle\Runner\Task\Zip\ZipExtractToTask;

class FullImportRemoteSensingZipShapefileJob extends AbstractImportRemoteSensingSitesZipShapefileJob
{
    use ValidatorTrait;

    const KEY_VALIDATION_CSV_PATH = 'validation-csv-path';

    public function getName(): string
    {
        return 'app:job:import:full-remote-sensing-sites-zip';
    }

    public function getDescription(): string
    {
        return 'Importing remote sensing found sites zip file into to "public"."site"';
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
                'class' => GetContributeMetadataFromTextFileTask::class,
                'condition' => 'hasContribute',
                'negateCondition' => true,
                'parameters' => [
                    ['setTextMetadataFilePath', 'getTextMetadataFilePath'],
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
                'class' => InsertRemoteSensingShpIntoTmpDraftTask::class,
                'parameters' => [
                    ['setContribute', 'getContribute'],
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => ValidateTmpDraftEntriesTaskToCsv::class,
                'parameters' => [
                    ['setValidator', 'getValidator'],
                    ['setEntityManager', 'getEntityManager'],
                    ['setValidationCsvFilePath', 'getShapefilePath'],
                    ['setContribute', 'getContribute'],
                ],
                'setters' => [
                    ['setDraftValid', 'isDraftValid'],
                    ['setValidationCsvFilePath', 'getValidationCsvFilePath'],
                ],
            ],
            [
                'class' => DisableMaterializedSiteUpdateTriggerTask::class,
                'condition' => 'isDraftValid',
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                ],
            ],
            [
                'class' => PersistSitesFromTmpDraftTaskSQL::class,
                'condition' => 'isDraftValid',
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                    ['setContribute', 'getContribute'],
                ],
            ],
            [
                'class' => UpdateMaterializedSiteViewTask::class,
                'condition' => 'isDraftValid',
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                    ['setContribute', 'getContribute'],
                ],
            ],
        ];
    }

    public function getValidationCsvFilePath(bool $throw = true): string
    {
        return $this->getParameter(self::KEY_VALIDATION_CSV_PATH, $throw);
    }

    public function setValidationCsvFilePath(string $path)
    {
        return $this->getParameters()->set(self::KEY_VALIDATION_CSV_PATH, $path);
    }
}
