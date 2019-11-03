<?php


namespace App\Service\SQLPersister;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;

class InsertGeomSiteSQLPersiter
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Statement
     */
    private $insertIntoSiteStatement;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(array $draft): int
    {
        $params = [
            'id' => $draft['id'],
            'geom' => $draft['geom']
        ];
        $this->getInsertIntoSiteStatement()->execute($params);
        return $params['id'];
    }

    private function prepareInsertIntoSiteStatement(): Statement
    {
        $conn = $this->em->getConnection();
        $sql = <<<EOF
        INSERT INTO "geom"."site"
	(
	 "id",
	 "geom"
	 )
	VALUES (
	        :id, 
	        ST_GeomFromGeoJSON(:geom)
	        )
	RETURNING "id";
EOF;
        return $conn->prepare($sql);
    }

    private function getInsertIntoSiteStatement(): Statement
    {
        if (!$this->insertIntoSiteStatement) {
            $this->insertIntoSiteStatement = $this->prepareInsertIntoSiteStatement();
        }
        return $this->insertIntoSiteStatement;
    }
}
