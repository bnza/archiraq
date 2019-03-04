<?php

namespace App\Runner\Job;

use App\Runner\Task\Database\PersistSitesFromTmpDraftsTask;
use App\Runner\Task\Database\ValidateTmpDraftEntriesTask;
use App\Entity\ContributeEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ImportSitesFromTmpDraftJob extends AbstractDatabaseJob
{
    const KEY_VALIDATOR = 'validator';
    const KEY_CONTRIBUTE = 'contribute';

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
                'class' => ValidateTmpDraftEntriesTask::class,
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

    public function setContribute($contribute)
    {
        if (!(is_int($contribute) || $contribute instanceof ContributeEntity)) {
          throw new \InvalidArgumentException("Invalid contribute");
        }
        $this->getParameters()->set(self::KEY_CONTRIBUTE, $contribute);
    }

    public function getContribute(): ContributeEntity
    {
        $contribute = $this->getParameter(self::KEY_CONTRIBUTE);
        if (is_int($contribute)) {
            $contribute = $this->getEntityManager()->getRepository(ContributeEntity::class)->find($contribute);
            $this->setContribute($contribute);
        }
        return $contribute;
    }

    protected function isContributeValidated(): bool
    {
        return $this->getContribute()->isValidated();
    }
}
