<?php


namespace App\Service\SQLPersister;


use App\Service\ParametersConverter\TmpDraftArrayToPublicSiteChronologyParametersArrayConverter;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;

class InsertPublicSiteChronologySQLPersister
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Statement
     */
    private $insertIntoSiteStatement;

    /**
     * @var TmpDraftArrayToPublicSiteChronologyParametersArrayConverter
     */
    private $siteConverter;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(array $draft): int
    {
        $paramsList = $this->getSiteChronologyConverter()->convert($draft);
        $params = ['site_id' => $paramsList['site_id']];
        foreach ($paramsList['site_chronologies'] as $chronologyId) {
            $params['chronology_id'] = $chronologyId;
            try {
                $this->getInsertIntoSiteStatement()->execute($params);
            } catch (\PDOException $e) {
                $refs = $draft['entry_id'];
                throw new \RuntimeException($e->getMessage().': '.$refs);
            }

        }
        return $paramsList['site_id'];
    }

    private function prepareInsertIntoSiteStatement(): Statement
    {
        $conn = $this->em->getConnection();
        $sql = <<<EOF
        INSERT INTO "public"."site_chronology"
	(
	 "site_id",
	 "chronology_id"
	 )
	VALUES (
	        :site_id, 
	        :chronology_id
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

    private function getSiteChronologyConverter(): TmpDraftArrayToPublicSiteChronologyParametersArrayConverter
    {
        if (!$this->siteConverter)
        {
            $this->siteConverter = new TmpDraftArrayToPublicSiteChronologyParametersArrayConverter($this->em);
        }
        return $this->siteConverter;
    }
}
