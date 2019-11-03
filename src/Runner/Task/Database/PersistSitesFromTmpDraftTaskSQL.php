<?php


namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Repository\Tmp\DraftRepository;
use App\Runner\Task\ContributeTrait;
use App\Runner\Task\TaskEntityManagerTrait;
use App\Service\SQLPersister\InsertGeomSiteSQLPersiter;
use App\Service\SQLPersister\InsertPublicSiteChronologySQLPersiter;
use App\Service\SQLPersister\InsertPublicSiteSurveySQLPersiter;
use App\Service\SQLPersister\InsertPublicSiteSQLPersiter;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\ORM\EntityManagerInterface;


class PersistSitesFromTmpDraftTaskSQL extends AbstractTask
{
    use TaskEntityManagerTrait;
    use ContributeTrait;

    /**
     * @var InsertPublicSiteSQLPersiter
     */
    private $sitePersiter;

    /**
     * @var InsertGeomSiteSQLPersiter
     */
    private $siteGeomPersiter;

    /**
     * @var InsertPublicSiteChronologySQLPersiter
     */
    private $siteChronologyPersister;

    /**
     * @var InsertPublicSiteSurveySQLPersiter
     */
    private $siteSurveyPersister;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:persist-tmp-drafts-sql';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Persisting temporary draft entities "tmp"."draft" to DB using plain SQL';
    }

    /**
     * {@inheritdoc}
     */
    public function getSteps(): iterable
    {
        $contribute = $this->getContribute();

        $generator = function () use ($contribute) {
            /**
             * @var EntityManagerInterface $em
             */
            $em = $this->getEntityManager();
            /**
             * @var DraftRepository $repo
             */
            $repo = $em->getRepository(DraftEntity::class);
            foreach ($repo->getByContributeAsArray($contribute_id = $contribute->getId()) as $draft) {
                $draft['contribute_id'] = $contribute_id;
                yield [$draft];
            }
        };

        return $generator();
    }

    /**
     * {@inheritdoc}
     */
    protected function executeStep(array $arguments): void
    {
        $this->persistSite(...$arguments);
    }

    protected function persistSite(array $draft)
    {
        $draft['id'] = $this->getPublicSitePersiter()->insert($draft);
        $this->getGeomSitePersiter()->insert($draft);
        $this->getSiteChronologyPersister()->insert($draft);
        $this->getSiteSurveyPersister()->insert($draft);
    }

    private function getPublicSitePersiter(): InsertPublicSiteSQLPersiter
    {
        if (!$this->sitePersiter) {
            $this->sitePersiter = new InsertPublicSiteSQLPersiter($this->getEntityManager());
        }
        return $this->sitePersiter;
    }

    private function getGeomSitePersiter(): InsertGeomSiteSQLPersiter
    {
        if (!$this->siteGeomPersiter) {
            $this->siteGeomPersiter = new InsertGeomSiteSQLPersiter($this->getEntityManager());
        }
        return $this->siteGeomPersiter;
    }

    private function getSiteChronologyPersister(): InsertPublicSiteChronologySQLPersiter
    {
        if (!$this->siteChronologyPersister) {
            $this->siteChronologyPersister = new InsertPublicSiteChronologySQLPersiter($this->getEntityManager());
        }
        return $this->siteChronologyPersister;
    }

    private function getSiteSurveyPersister(): InsertPublicSiteSurveySQLPersiter
    {
        if (!$this->siteSurveyPersister) {
            $this->siteSurveyPersister = new InsertPublicSiteSurveySQLPersiter($this->getEntityManager());
        }
        return $this->siteSurveyPersister;
    }
}
