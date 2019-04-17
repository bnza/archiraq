<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Repository\Tmp\DraftRepository;
use App\Runner\Task\TaskEntityManagerTrait;
use App\Runner\Task\ValidatorTrait;
use App\Serializer\TmpDraftToSiteConverter;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use App\Entity\ContributeEntity;

abstract class AbstractValidateTmpDraftEntriesTask extends AbstractTask
{
    use TaskEntityManagerTrait;
    use ValidatorTrait;

    /**
     * @var bool
     */
    protected $draftContainsErrors = false;

    /**
     * @var ContributeEntity
     */
    protected $contribute;

    /**
     * @var TmpDraftToSiteConverter
     */
    protected $converter;

    /**
     * Persists constraint validation errors.
     *
     * @param DraftEntity $draft
     * @param $errors
     */
    abstract protected function persistErrors(DraftEntity $draft, $errors);

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
        $contribute = $this->getContribute()->getId();

        $generator = function () use ($contribute) {
            /** @var DraftRepository $repo */
            $repo = $this->getEntityManager()->getRepository(DraftEntity::class);
            $rowsNum = $this->getStepsNum();
            $limit = 100;
            $offset = 0;
            while ($offset < $rowsNum) {
                foreach ($repo->findBy(['contribute' => $contribute], null, $limit, $offset) as $draft) {
                    yield [$draft];
                }
                $offset += $limit;
            }
        };

        return $generator();
    }

    /**
     * {@inheritdoc}
     */
    protected function terminate(): void
    {
        $this->updateContributeStatus();
    }

    /**
     * Update ContributeEntity Status according to validation results.
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
     * Update ContributeEntity Status VALID flag according to validation results.
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
     * Validates DraftEntity instance SiteBoundaryEntity and persists error to DB.
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
     * Convert DraftEntity instance to SiteEntity one, validates it and persists error to DB.
     *
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

    /**
     * {@inheritdoc}
     */
    protected function countStepsNum(): int
    {
        /** @var DraftRepository $repo */
        $repo = $this->getEntityManager()->getRepository(DraftEntity::class);

        return $repo->countByContribute($this->getContribute()->getId());
    }

    public function isDraftValid(): bool
    {
        return !$this->draftContainsErrors;
    }
}
