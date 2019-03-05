<?php

namespace App\Runner\Job;

use App\Runner\Task\Database\ValidateTmpDraftEntriesTask;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ValidateTmpDraftEntriesJob extends AbstractDatabaseJob
{
    use ContributeTrait;

    const KEY_VALIDATOR = 'validator';

    public function getName(): string
    {
        return 'app:job:validate:tmp-draft';
    }

    public function getDescription(): string
    {
        return 'Validating temporary draft entries';
    }

    public function getSteps(): iterable
    {
        return [
            [
                'class' => ValidateTmpDraftEntriesTask::class,
                'parameters' => [
                    ['setValidator', 'getValidator'],
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


}
