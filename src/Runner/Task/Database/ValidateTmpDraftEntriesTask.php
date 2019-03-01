<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 05/02/19
 * Time: 14.50.
 */

namespace App\Runner\Task\Database;

use App\Entity\TmpDraftEntity;
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
        return 'Validating temporary draft entities ("tmp""draft") to DB';
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
        $this->getEntityManager()->refresh($contribute);

        $generator = function () use ($contribute) {
            foreach ($contribute->getTmpDrafts()as $draft) {
                yield [$draft];
            }
        };

        return $generator();
    }

    protected function terminate(): void
    {
        $this->getEntityManager()->flush();
    }

    protected function validate(TmpDraftEntity $draft)
    {
        $this->validateDraft($draft);
        $this->validateSite($draft);
    }

    /**
     * Validates TmpDraftEntity instance SiteBoundaryEntity  and persists error to DB
     *
     * @param TmpDraftEntity $draft
     */
    protected function validateDraft(TmpDraftEntity $draft)
    {
        $errors = $this->getValidator()->validate($draft);
        if (count($errors) > 0) {
            $this->persistErrors($draft, $errors);
        }
    }

    /**
     * Convert TmpDraftEntity instance to SiteEntity one, validates it and persists error to DB
     * @param TmpDraftEntity $draft
     */
    protected function validateSite(TmpDraftEntity $draft)
    {
        $site = $this->getConverter()->convert($draft);
        $errors = $this->getValidator()->validate($site);
        if (count($errors) > 0) {
            $this->persistErrors($draft, $errors);
        }
    }

    /**
     * Persists constraint validation errors to DB
     * @param TmpDraftEntity $draft
     * @param $errors
     */
    protected function persistErrors(TmpDraftEntity $draft, $errors)
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
