<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Serializer\ConstraintViolationToTmpDraftErrorConverter;

class ValidateTmpDraftEntriesTaskToDb extends AbstractValidateTmpDraftEntriesTask
{

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:validate-tmp-draft-to-db';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Validating temporary draft entities ("tmp"."draft") to Spreadsheet';
    }

    /**
     * Persists constraint validation errors to DB
     * @param DraftEntity $draft
     * @param $errors
     */
    protected function persistErrors(DraftEntity $draft, $errors)
    {
        $converter = new ConstraintViolationToTmpDraftErrorConverter();
        $em = $this->getEntityManager();
        foreach ($errors as $key => $violation) {
            $error = $converter->convert($violation);
            $draft->addError($error);
        }
        $em->persist($draft);
    }
}
