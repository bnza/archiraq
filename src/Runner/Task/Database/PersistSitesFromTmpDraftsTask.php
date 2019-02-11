<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 05/02/19
 * Time: 14.50
 */

namespace App\Runner\Task\Database;


use App\Entity\SiteEntity;
use App\Entity\TmpDraftEntity;
use App\Runner\Task\TaskEntityManagerTrait;
use App\Serializer\TmpDraftToSiteConverter;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use App\Entity\ContributeEntity;


class PersistSitesFromTmpDraftsTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    /**
     * @var SiteEntity[]
     */
    protected $sites = [];

    /**
     * @var ContributeEntity
     */
    protected $contribute;

    /**
     * @var TmpDraftToSiteConverter
     */
    protected $converter;

    public function getName(): string
    {
        return 'app:task:db:persist-tmp-drafts';
    }

    public function getDefaultDescription(): string
    {
        return 'Persisting temporary draft entities ("tmp""draft") to DB';
    }

    protected function executeStep(array $arguments): void
    {
        $this->persistSite(...$arguments);
    }

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
        $this->getEntityManager()->flush($this->sites);
    }

    protected function persistSite(TmpDraftEntity $draft)
    {
        $this->sites[] = $site = $this->getConverter()->convert($draft);
        $this->getEntityManager()->persist($site);
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

    protected function getConverter(): TmpDraftToSiteConverter
    {
        if (!$this->converter) {
            $this->converter = new TmpDraftToSiteConverter();
        }
        return $this->converter;
    }
}
