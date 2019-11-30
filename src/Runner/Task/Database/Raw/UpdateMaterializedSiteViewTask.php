<?php


namespace App\Runner\Task\Database\Raw;

use App\Entity\SiteEntity;
use App\Runner\Task\ContributeTrait;
use App\Serializer\EntityManagerTrait;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\DBAL\Statement;

class UpdateMaterializedSiteViewTask extends AbstractTask
{
    use EntityManagerTrait;
    use ContributeTrait;

    /**
     * @var Statement
     */
    protected $stmt;

    public function getName(): string
    {
        return 'app:task:db:raw:update-mat_site-after-insert';
    }

    public function getDefaultDescription(): string
    {
        return 'Update "geom"."mat_site" table';
    }

    protected function executeStep(array $arguments): void
    {
        /**
         * @var SiteEntity $site
         */
        $site = $arguments[0];
        $id = $site->getId();
        $this->getUpdatePreparedStatement()->execute(['new_id' => $id, 'old_id' => $id]);
    }

    public function getSteps(): iterable
    {
        $contribute = $this->getContribute();

        $this->getEntityManager()->refresh($contribute);

        $generator = function () use ($contribute) {
            foreach ($contribute->getSites() as $site) {
                yield [$site];
            }
        };

        return $generator();
    }

    protected function getUpdatePreparedStatement()
    {
        if (!$this->stmt) {
            $this->prepareInsertQueryStatement();
        }

        return $this->stmt;
    }

    protected function prepareInsertQueryStatement()
    {
        $sql = <<<EOT
SELECT "geom".update_mat_site_by_index(:new_id,:old_id);
EOT;
        $this->stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    }
}
