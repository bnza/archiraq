<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Entity\Tmp\DraftErrorEntity;
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

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->deleteContributeDraftErrors();
    }

    /**
     * {@inheritdoc}
     */
    protected function terminate(): void
    {
        parent::terminate();
        $this->getEntityManager()->flush();
        parent::terminate();
    }

    /**
     * Remove old contribute's draft errors before validate
     */
    protected function deleteContributeDraftErrors()
    {
        $em = $this->getEntityManager();
        $errors = $em
            ->getRepository(DraftErrorEntity::class)
            ->getByContribute($this->getContribute()->getId())
        ;
        foreach ($errors as $error) {
            $em->remove($error);
        }
    }
}
