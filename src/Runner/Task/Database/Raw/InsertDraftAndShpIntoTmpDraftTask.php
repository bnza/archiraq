<?php

namespace App\Runner\Task\Database\Raw;

use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\DBAL\Statement;

class InsertDraftAndShpIntoTmpDraftTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    /**
     * @var Statement
     */
    protected $stmt;

    public function getName(): string
    {
        return 'app:task:db:raw:insert-draft-shp-into-tmp-draft';
    }

    public function getDefaultDescription(): string
    {
        return 'Inserting temporary draft and shape data into "tmp"."draft"';
    }

    public function getSteps(): iterable
    {
        foreach ($this->getIdGenerator() as $id) {
            yield [$id];
        }
    }

    protected function executeStep(array $arguments): void
    {
        $id = $this->getJob()->getId();
        $draft = "draft$id";
        $shp = "shp2pgsql$id";
        $sql = <<<EOT
    SELECT d."contribute_id", d."entry_id", d."modern_name", d."ancient_name", d."district", d."nearest_city", d."cadastre", d."sbah_no", d."survey_visit_date", d."survey_verified_on_field", d."survey_type", d."survey_prev_refs", d."features_epigraphic", d."features_ancient_structures", d."features_paleochannels", d."features_remarks", d."site_chronology", d."excavations_whom_when", d."excavations_bibliography", d."threats_natural_dunes", d."threats_looting", d."threats_cultivation_trenches", d."threats_modern_structures", d."threats_modern_canals", d."remarks", d."compiler", d."compilation_date", d."credits", s."geom"
    FROM "$draft" d 
    JOIN "tmp"."$shp" s
    ON d."entry_id" = s."id"
    WHERE d."entry_id" = :id
EOT;

        $sql2 = "select * from \"tmp\".\"$shp\"";
        $values2 = $this->getEntityManager()->getConnection()->fetchAll($sql2);
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute(['id' => $arguments[0]]);
        $values = $stmt->fetchAll();
        $this->getInsertPreparedStatement()->execute(['id' => $arguments[0]]);
    }

    protected function getIdGenerator()
    {
        $id = $this->getJob()->getId();
        $draft = "draft$id";
        $sql = <<<EOT
SELECT entry_id FROM "$draft"
EOT;
        $generator = function () use ($sql) {
            foreach ($this->getEntityManager()->getConnection()->fetchAll($sql) as $row) {
                yield $row['entry_id'];
            }
        };

        return $generator();
    }

    protected function getInsertPreparedStatement()
    {
        if (!$this->stmt) {
            $this->prepareInsertQueryStatement();
        }

        return $this->stmt;
    }

    protected function prepareInsertQueryStatement()
    {
        $id = $this->getJob()->getId();
        $draft = "draft$id";
        $shp = "shp2pgsql$id";
        $sql = <<<EOT
INSERT INTO "tmp"."draft"
    ("contribute_id", "entry_id", "modern_name", "ancient_name", "district", "nearest_city", "cadastre", "sbah_no", "survey_visit_date", "survey_verified_on_field", "survey_type", "survey_prev_refs", "features_epigraphic", "features_ancient_structures", "features_paleochannels", "features_remarks", "site_chronology", "excavations_whom_when", "excavations_bibliography", "threats_natural_dunes", "threats_looting", "threats_cultivation_trenches", "threats_modern_structures", "threats_modern_canals", "remarks", "compiler", "compilation_date", "credits", "geom")
    SELECT d."contribute_id", d."entry_id", d."modern_name", d."ancient_name", d."district", d."nearest_city", d."cadastre", d."sbah_no", d."survey_visit_date", d."survey_verified_on_field", d."survey_type", d."survey_prev_refs", d."features_epigraphic", d."features_ancient_structures", d."features_paleochannels", d."features_remarks", d."site_chronology", d."excavations_whom_when", d."excavations_bibliography", d."threats_natural_dunes", d."threats_looting", d."threats_cultivation_trenches", d."threats_modern_structures", d."threats_modern_canals", d."remarks", d."compiler", d."compilation_date", d."credits", s."geom"
    FROM "$draft" d 
    JOIN "tmp"."$shp" s
    ON d."entry_id" = s."id"
    WHERE d."entry_id" = :id
EOT;
        $this->stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    }
}
