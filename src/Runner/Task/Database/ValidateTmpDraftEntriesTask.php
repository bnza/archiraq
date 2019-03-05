<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Entity\Tmp\DraftErrorEntity;
use App\Runner\Task\TaskEntityManagerTrait;
use App\Runner\Task\ValidatorTrait;
use App\Serializer\ConstraintViolationToTmpDraftErrorConverter;
use App\Serializer\TmpDraftToSiteConverter;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use App\Entity\ContributeEntity;

class ValidateTmpDraftEntriesTask extends AbstractTask
{
    use TaskEntityManagerTrait;
    use ValidatorTrait;

    /**
     * @var ContributeEntity
     */
    protected $contribute;

    /**
     * @var TmpDraftToSiteConverter
     */
    protected $converter;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:validate-tmp-draft';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Validating temporary draft entities ("tmp"."draft") to DB';
    }

    /**
     * {@inheritdoc}
     */
    protected function executeStep(array $arguments): void
    {
        $this->validate(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function getSteps(): iterable
    {
        $contribute = $this->getContribute();

        $generator = function () use ($contribute) {
            foreach ($contribute->getDrafts() as $draft) {
                yield [$draft];
            }
        };

        return $generator();
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
        $this->getEntityManager()->flush();
        $this->updateContributeStatus();
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

    /**
     * Update ContributeEntity Status according to validation results
     */
    protected function updateContributeStatus()
    {
        $contribute = $this->getContribute();
        $status = $contribute->getStatus();
        $status |= ContributeEntity::STATUS_VALIDATE;
        $this->updateContributeStatusValidFlag($status);
        $this->getContribute()->setStatus($status);
        $this->getEntityManager()->persist($contribute);
        $this->getEntityManager()->flush($contribute);
    }

    /**
     * Update ContributeEntity Status VALID flag according to validation results
     *
     * @param int $status
     */
    protected function updateContributeStatusValidFlag(int &$status)
    {
        $repo = $this->getEntityManager()->getRepository(ContributeEntity::class);
        $isValid = !$repo->hasDraftErrors($this->getContribute()->getId());
        if ($isValid) {
            $status |= ContributeEntity::STATUS_VALID;
        } else {
            $status &= ~ContributeEntity::STATUS_VALID;
        }
    }

    protected function validate(DraftEntity $draft)
    {
        $this->validateDraft($draft);
        $this->validateSite($draft);
    }

    /**
     * Validates DraftEntity instance SiteBoundaryEntity  and persists error to DB
     *
     * @param DraftEntity $draft
     */
    protected function validateDraft(DraftEntity $draft)
    {
        $errors = $this->getValidator()->validate($draft);
        if (count($errors) > 0) {
            $this->persistErrors($draft, $errors);
        }
    }

    /**
     * Convert DraftEntity instance to SiteEntity one, validates it and persists error to DB
     * @param DraftEntity $draft
     */
    protected function validateSite(DraftEntity $draft)
    {
        $site = $this->getConverter()->convert($draft);
        $errors = $this->getValidator()->validate($site);
        if (count($errors) > 0) {
            $this->persistErrors($draft, $errors);
        }
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
     * @return ContributeEntity
     */
    public function getContribute(): ContributeEntity
    {
        return $this->contribute;
    }

    /**
     * @param mixed $contribute
     */
    public function setContribute(ContributeEntity $contribute): void
    {
        $this->contribute = $contribute;
    }

    /**
     * @return TmpDraftToSiteConverter
     */
    protected function getConverter(): TmpDraftToSiteConverter
    {
        if (!$this->converter) {
            $this->converter = new TmpDraftToSiteConverter($this->getEntityManager());
        }

        return $this->converter;
    }
}
