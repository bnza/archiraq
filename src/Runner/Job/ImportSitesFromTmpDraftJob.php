<?php

namespace App\Runner\Job;

use App\Runner\Task\Database\PersistSitesFromTmpDraftsTask;
use App\Runner\Task\Database\ValidateTmpDraftEntriesTaskToDb;
use App\Entity\ContributeEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ImportSitesFromTmpDraftJob extends AbstractDatabaseJob
{
    use ContributeTrait;

    const KEY_VALIDATOR = 'validator';

    public function getName(): string
    {
        return 'app:job:import:tmp-draft';
    }

    public function getDescription(): string
    {
        return 'Importing "tmp"."draft" entries';
    }

    public function getSteps(): iterable
    {
        return [
            [
                'class' => ValidateTmpDraftEntriesTaskToDb::class,
                'condition' => ['isContributeValidated'],
                'negateCondition' => true,
                'parameters' => [
                    ['setValidator', 'getValidator'],
                    ['setEntityManager', 'getEntityManager'],
                    ['setContribute', 'getContribute'],
                ],
            ],
            [
                'class' => PersistSitesFromTmpDraftsTask::class,
                'parameters' => [
                    ['setEntityManager', 'getEntityManager'],
                    ['setContribute', 'getContribute'],
                ],
            ],
        ];
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->getParameters()->set(self::KEY_VALIDATOR, $validator);
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->getParameter(self::KEY_VALIDATOR);
    }

    protected function isContributeValidated(): bool
    {
        return $this->getContribute()->isValidated();
    }
}
