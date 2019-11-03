<?php


namespace App\Service\SQLPersister;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;

class InsertVocSurveySQLPersiter
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
        $params = array_merge(['name' => null, 'remarks' => null], $draft);
        $this->getInsertIntoSiteStatement()->execute($params);
        return $this->em->getConnection()->lastInsertId();
    }

    private function prepareInsertIntoSiteStatement(): Statement
    {
        $conn = $this->em->getConnection();
        $sql = <<<EOF
        INSERT INTO "voc"."survey"
	(
	 "code",
	 "name",
	 "remarks"
	 )
	VALUES (
	        :code, 
	        :name,
	        :remarks
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
