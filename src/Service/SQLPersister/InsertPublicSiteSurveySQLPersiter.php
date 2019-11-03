<?php


namespace App\Service\SQLPersister;


use App\Entity\Voc\SurveyEntity;
use App\Service\ParametersConverter\TmpDraftArrayToPublicSiteSurveyParametersArrayConverter;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;

class InsertPublicSiteSurveySQLPersiter
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
     * @var InsertVocSurveySQLPersiter
     */
    private $surveyPersister;

    /**
     * @var TmpDraftArrayToPublicSiteSurveyParametersArrayConverter
     */
    private $siteConverter;

    private $surveys = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(array $draft): int
    {
        $paramsList = $this->getSiteSurveyConverter()->convert($draft);
        foreach ($paramsList['site_surveys'] as $params) {
            if (!is_int($params['survey_id'])) {
                $params['survey_id'] = $this->createSurvey($params['survey_id']);
            }
            $this->getInsertIntoSiteStatement()->execute($params);
        }
        return $paramsList['site_id'];
    }

    private function createSurvey(string $surveyCode): int
    {
        if (!\array_key_exists($surveyCode, $this->surveys)) {
            $this->surveys[$surveyCode] = $this->getSurveyPersiter()->insert(['code' => $surveyCode]);
        }
        return $this->surveys[$surveyCode];
    }

    private function prepareInsertIntoSiteStatement(): Statement
    {
        $conn = $this->em->getConnection();
        $sql = <<<EOF
        INSERT INTO "public"."site_survey"
	(
	 "site_id",
	 "survey_id",
	 "ref",
	 "year_low",
	 "year_high",
	 "remarks"
	 )
	VALUES (
	        :site_id, 
	        :survey_id,
	        :ref,
	        :year_low,
	        :year_high,
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

    private function getSiteSurveyConverter(): TmpDraftArrayToPublicSiteSurveyParametersArrayConverter
    {
        if (!$this->siteConverter)
        {
            $this->siteConverter = new TmpDraftArrayToPublicSiteSurveyParametersArrayConverter($this->em);
        }
        return $this->siteConverter;
    }

    private function getSurveyPersiter(): InsertVocSurveySQLPersiter
    {
        if (!$this->surveyPersister)
        {
            $this->surveyPersister = new InsertVocSurveySQLPersiter($this->em);
        }
        return $this->surveyPersister;
    }
}
