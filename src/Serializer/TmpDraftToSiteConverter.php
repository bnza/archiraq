<?php

namespace App\Serializer;

use App\Entity\EntityInterface;
use App\Entity\SiteSurveyEntity;
use App\Entity\Voc\SurveyEntity;
use App\Entity\Voc\ChronologyEntity;
use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteEntity;
use App\Entity\Tmp\DraftEntity;
use App\Serializer\Denormalizer\SiteEntityDenormalizer;
use App\Serializer\Normalizer\TmpDraftEntityNormalizer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Serializer\Serializer;

class TmpDraftToSiteConverter extends AbstractEntityConverter
{
    use SerializerTrait;
    use EntityManagerTrait;

    /**
     * @var SurveyEntity[]
     */
    private $surveys = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    protected function initSerializer(): Serializer
    {
        return new Serializer([new TmpDraftEntityNormalizer(), new SiteEntityDenormalizer()]);
    }

    public function getSourceClass(): string
    {
        return DraftEntity::class;
    }

    public function getTargetClass(): string
    {
        return SiteEntity::class;
    }

    /**
     * @param EntityInterface $object
     * @param array $context
     */
    protected function preNormalize($object, array &$context = []): void
    {
        $context['contribute'] = $object->getContribute();
    }

    protected function getDistrict(?string $districtName): ?DistrictBoundaryEntity
    {
        if (!$districtName) {
            return null;
        }
        try {
            return $this->getEntityManager()->getRepository(DistrictBoundaryEntity::class)->findByName($districtName);
        } catch (NoResultException $e) {
            return null;
        }

    }

    /**
     * Prepares DraftEntity for SiteEntity denormalization
     *
     * @see SiteEntityDenormalizer::denormalize()
     * @param array $object
     * @param array $context
     */
    protected function preDenormalize(array &$object, array &$context = []): void
    {
        $this->setSiteGeom($object);
        $object['district'] = $this->getDistrict($object['district']);//$this->getEntityManager()->getRepository(DistrictBoundaryEntity::class)->findByName($object['district'], false, false);
        $object['contribute'] = $context['contribute'];
        $context['site_chronology'] = $this->setChronologies($object);
        unset($object['site_chronology']);
        $context['site_prev_refs'] = $this->setSurveys($object);
        unset($object['site_prev_refs']);
        unset($object['site_visit_date']);
    }

    protected function setSiteGeom(array &$object)
    {
        $geom = new SiteBoundaryEntity();
        $geom->setGeom($object['geom']);
        $object['geom'] = $geom;
    }

    protected function setChronologies(array $object)
    {
        $entities = [];
        if (
            \array_key_exists('siteChronology', $object)
            && is_string($object['siteChronology'])
        ) {
            $repo = $this->getEntityManager()->getRepository(ChronologyEntity::class);
            foreach (\explode(';', $object['siteChronology']) as $code) {
                $code = strtoupper(trim($code));
                $entities[] = $repo->findOneBy(['code' => $code]);
            }
        }
        return $entities;
    }

    protected function setSurveys(array $object)
    {
        $entities = [];
        $dates = [];
        $repo = $this->getEntityManager()->getRepository(SurveyEntity::class);

        if (
            \array_key_exists('surveyVisitDate', $object)
            && $object['surveyVisitDate']
        ) {
            $dates = \explode(';', $object['surveyVisitDate']);
        }

        if (
            \array_key_exists('surveyPrevRefs', $object)
            && $object['surveyPrevRefs']
        ) {
            foreach (\explode(';', $object['surveyPrevRefs']) as $i => $ref) {
                $ref = explode('.', $ref);
                $ksurvey = strtoupper(trim(\array_shift($ref)));

                /**
                 * survey code adams1972.009 -> ADAMS1972
                 */
                if (!\array_key_exists($ksurvey, $this->surveys)) {
                    $survey = $repo->findOneBy(['code' => $ksurvey]);
                    if (!$survey) {
                        // No survey found. Adding new one
                        $survey = new SurveyEntity();
                        $survey->setCode($ksurvey);
                        $this->getEntityManager()->persist($survey);
                    }
                    $this->surveys[$ksurvey] = $survey;
                } else {
                    $survey = $this->surveys[$ksurvey];
                }

                $siteSurvey = new SiteSurveyEntity();
                $siteSurvey->setSurvey($survey);

                /**
                 * survey refs
                 * e.g. ADAMS1972.001 -> 001
                 * e.g. SOMEONE2001.09.89? -> 09.89?
                 */
                if (count($ref)) {
                    $siteSurvey->setRef(\implode('.', $ref));
                }

                /**
                 * related survey visit dates
                 */
                if (array_key_exists($i, $dates)) {
                    $years = explode('-', $dates[$i]);
                    if (\is_numeric($years[0])) {
                        $siteSurvey->setYearLow((int)$years[0]);
                    }
                    if (
                        \array_key_exists(1, $years)
                        && \is_numeric($years[1])
                    ) {
                        $siteSurvey->setYearHigh((int)$years[1]);
                    }
                }
                $entities[] = $siteSurvey;
            }
        }
        return $entities;
    }
}
