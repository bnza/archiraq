<?php

namespace App\Runner\Task\Database\Raw;

use App\Runner\Task\ContributeTrait;

class InsertRemoteSensingShpIntoTmpDraftTask extends AbstractInsertIntoTmpDraftTask
{
    use ContributeTrait;

    public function getName(): string
    {
        return 'app:task:db:raw:insert-remote-sensing-shp-into-tmp-draft';
    }

    public function getDefaultDescription(): string
    {
        return 'Inserting remote sensing shape data into "tmp"."draft"';
    }

    protected function getIdGenerator(): \Generator
    {
        $id = $this->getJob()->getId();
        $shpTable = "shp2pgsql$id";
        $sql = <<<EOT
SELECT "id" FROM "tmp"."$shpTable"
EOT;
        $generator = function () use ($sql) {
            foreach ($this->getEntityManager()->getConnection()->fetchAll($sql) as $row) {
                yield $row['id'];
            }
        };

        return $generator();
    }

    protected function prepareInsertQueryStatement()
    {
        $id = $this->getJob()->getId();
        $shpTable = "shp2pgsql$id";
        $contributeId = $this->getContribute()->getId();
        $compilationDate = (new \DateTime())->format('Y-m-d');
        $sql = <<<EOT
INSERT INTO "tmp"."draft"
    ("contribute_id", "entry_id", "remote_sensing", "modern_name", "ancient_name", "district", "survey_verified_on_field", "threats_natural_dunes", "threats_looting", "threats_modern_structures", "threats_modern_canals", "threats_bulldozer", "remarks", "compilation_date", "compiler", "geom")
    SELECT $contributeId, d."id", 'y', d."mod_name", d."anc_name", d."district", d."verified", d."nat_damage", d."looting",d."structures", d."mod_channe", d."bulldozer", d."remarks", '$compilationDate', d."compiler", d."geom"
    FROM "tmp"."$shpTable" d 
    WHERE d."id" = :id
EOT;
        $this->stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    }
}
