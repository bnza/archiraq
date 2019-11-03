<?php


namespace App\Service\SQLPersister;


use App\Service\ParametersConverter\TmpDraftArrayToPublicSiteParametersArrayConverter;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;

class InsertPublicSiteSQLPersiter
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
     * @var TmpDraftArrayToPublicSiteParametersArrayConverter
     */
    private $siteConverter;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(array $draft): int
    {
        $params = $this->getSiteConverter()->convert($draft);
        $this->getInsertIntoSiteStatement()->execute($params);
        return $this->em->getConnection()->lastInsertId();
    }

    private function prepareInsertIntoSiteStatement(): Statement
    {
        $conn = $this->em->getConnection();
        $sql = <<<EOF
        INSERT INTO "public"."site"
	(
	 "contribute_id",
	 "entry_id",
	 "nearest_city",
	 "ancient_name",
	 "ancient_name_uncertain",
	 "modern_name",
	 "cadastre",
	 "compiler",
	 "compilation_date",
	 "remarks",
	 "credits",
	 "sbah_no",
	 "features_epigraphic",
	 "features_ancient_structures",
	 "features_paleochannels",
	 "features_remarks",
	 "threats_natural_dunes",
	 "threats_looting",
	 "threats_cultivation_trenches",
	 "threats_modern_structures",
	 "threats_modern_canals",
	 "district_id",
	 "threats_bulldozer",
	 "remote_sensing",
	 "survey_verified_on_field"
	 )
	VALUES (
	        :contribute_id, 
	        :entry_id,
	        :nearest_city,
	        :ancient_name,
	        :ancient_name_uncertain,
	        :modern_name, 
	        :cadastre, 
	        :compiler,
	        :compilation_date,
	        :remarks,
	        :credits, 
	        :sbah_no, 
	        :features_epigraphic, 
	        :features_ancient_structures, 
	        :features_paleochannels, 
	        :features_remarks, 
	        :threats_natural_dunes, 
	        :threats_looting, 
	        :threats_cultivation_trenches, 
	        :threats_modern_structures, 
	        :threats_modern_canals, 
	        :district_id, 
	        :threats_bulldozer, 
	        :remote_sensing, 
	        :survey_verified_on_field
	        )
	RETURNING "id";
EOF;
        return $conn->prepare($sql);
    }

    private function getSiteConverter(): TmpDraftArrayToPublicSiteParametersArrayConverter
    {
        if (!$this->siteConverter)
        {
            $this->siteConverter = new TmpDraftArrayToPublicSiteParametersArrayConverter($this->em);
        }
        return $this->siteConverter;
    }

    private function insertIntoSite(array $draft): int
    {
        $params = $this->getSiteConverter()->convert($draft);
        $result = $this->getInsertIntoSiteStatement()->execute($params);
        $id = $this->em->getConnection()->lastInsertId();
        return $id;
    }

    private function getInsertIntoSiteStatement(): Statement
    {
        if (!$this->insertIntoSiteStatement) {
            $this->insertIntoSiteStatement = $this->prepareInsertIntoSiteStatement();
        }
        return $this->insertIntoSiteStatement;
    }
}
