<?php


namespace App\Service\ParametersConverter;


use App\Entity\Voc\SurveyEntity;
use App\Repository\Voc\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;

class TmpDraftArrayToPublicSiteSurveyParametersArrayConverter
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SurveyRepository
     */
    private $surveyRepository;

    /**
     * @var array
     */
    private $surveys = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $draft
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function convert(array $draft): array
    {
        $params = [
            'site_id' => $draft['id']
        ];
        $params['site_surveys'] = $this->getSurveyPreviousReferences($draft);
        return $params;
    }

    private function getSurveyRepository(): SurveyRepository
    {
        if (!$this->surveyRepository) {
            $this->surveyRepository = $this->em->getRepository(SurveyEntity::class);
        }
        return $this->surveyRepository;
    }

    private function getSurveyPreviousReferences(array $draft): array
    {
        $params = [];
        if (!array_key_exists('survey_prev_refs', $draft)) {
            return $params;
        }

        if (!$draft['survey_prev_refs']) {
            return $params;
        }

        $surveyRefs = \explode(';', $draft['survey_prev_refs']);
        $surveyVisits = \explode(';', $draft['survey_visit_date']);
        foreach ($surveyRefs as $i => $surveyRef) {
            $surveyVisit = array_key_exists($i, $surveyVisits) ? $surveyVisits[$i] : null;
            $params[] = $this->normalizeSurveyPreviousReference($draft['id'], $surveyRef, $surveyVisit);
        }
        return $params;
    }

    private function normalizeSurveyPreviousReference(int $siteId, string $surveyRef, ?string $surveyVisit): array
    {
        $params = [
            'site_id' => $siteId,
            'remarks' => null,
            'year_low' => null,
            'year_high' => null,
        ];

        /**
         * survey code adams1972.009 -> ADAMS1972
         */
        $refs = explode('.', $surveyRef);
        $surveyCode = strtoupper(trim($refs[0]));


        if (!\array_key_exists($surveyCode, $this->surveys)) {
            $survey = $this->getSurveyRepository()->findOneBy(['code' => $surveyCode]);
            $this->surveys[$surveyCode] = $survey ? $survey->getId() : $surveyCode;
        }

        $params['survey_id'] = $this->surveys[$surveyCode];

        /**
         * survey refs
         * e.g. ADAMS1972.001 -> 001
         */
        $params['ref'] = array_key_exists(1, $refs) ? trim($refs[1]) : null;

        if ($surveyVisit) {
            $years = explode('-', $surveyVisit);
            if (\is_numeric($years[0])) {
                $params['year_low'] = (int)$years[0];
            }
            if (
                \array_key_exists(1, $years)
                && \is_numeric($years[1])
            ) {
                $params['year_high'] = (int)$years[1];
            }
        }

        return $params;

    }

}
