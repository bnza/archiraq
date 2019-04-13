<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Runner\Task\ContributeTrait;
use App\Runner\Task\TaskEntityManagerTrait;
use App\Serializer\TmpDraftToSiteConverter;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;

class PersistSitesFromTmpDraftsTask extends AbstractTask
{
    use TaskEntityManagerTrait;
    use ContributeTrait;

    /**
     * @var TmpDraftToSiteConverter
     */
    protected $converter;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:persist-tmp-drafts';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Persisting temporary draft entities ("tmp""draft") to DB';
    }

    /**
     * {@inheritdoc}
     */
    protected function executeStep(array $arguments): void
    {
        $this->persistSite(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function getSteps(): iterable
    {
        $contribute = $this->getContribute();

        $this->getEntityManager()->refresh($contribute);
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
    protected function terminate(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * Converts DraftEntity in SiteBoundaryEntity and persists it.
     *
     * @param DraftEntity $draft
     */
    protected function persistSite(DraftEntity $draft)
    {
        $site = $this->getConverter()->convert($draft);
        $this->getEntityManager()->persist($site);
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
