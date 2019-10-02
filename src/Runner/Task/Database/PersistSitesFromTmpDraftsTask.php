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

    const PERSIST_CHUNK_SIZE = 50;

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
        if ($this->getCurrentStepNum() % self::PERSIST_CHUNK_SIZE === 0) {
            $this->flush();
        }
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

    protected function flush()
    {
        $this->setMessage('Flushing data to db. This may take a while...');
        $this->getEntityManager()->flush();
        $this->setMessage('');
    }

    /**
     * {@inheritdoc}
     */
    protected function terminate(): void
    {
        $this->flush();
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
