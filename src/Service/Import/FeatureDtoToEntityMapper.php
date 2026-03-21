<?php

namespace App\Service\Import;

use App\DTO\RemoteSensingFeatureDTO;
use App\DTO\SurveyFeatureDTO;
use App\DTO\SurveyNotSampledFeatureDTO;
use App\Entity\ContributeEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\SiteSurveyEntity;
use Doctrine\ORM\EntityManagerInterface;

class FeatureDtoToEntityMapper
{
    private $em;
    private $chronologyResolver;
    private $surveyResolver;
    private $districtResolver;

    public function __construct(
        EntityManagerInterface $em,
        ChronologyResolver $chronologyResolver,
        SurveyResolver $surveyResolver,
        DistrictResolver $districtResolver
    ) {
        $this->em = $em;
        $this->chronologyResolver = $chronologyResolver;
        $this->surveyResolver = $surveyResolver;
        $this->districtResolver = $districtResolver;
    }

    /**
     * @param object $dto One of the DTO classes
     * @param ContributeEntity $contribute
     * @return SiteEntity
     */
    public function map($dto, ContributeEntity $contribute): SiteEntity
    {
        $site = new SiteEntity();
        $site->setContribute($contribute);
        $site->setEntryId($dto->entry_id);
        $site->setModernName($dto->modern_nam);
        $site->setNearestCity($dto->nearest_ci);
        $site->setAncientName($dto->ancient_na);
        $site->setSbahNo($dto->sbah_no ?? null);
        $site->setCadastre($dto->cadastre ?? null);
        $site->setRemarks($dto->remarks);
        $site->setSurveyType($dto->survey_typ);
        $site->setRemoteSensing($dto->remote_sen === 'T' || $dto->remote_sen === true);
        $site->setSurveyVerifiedOnField($dto->survey_ver === 'T' || $dto->survey_ver === true);
        
        // District
        $district = $this->districtResolver->resolve((int)$dto->district_i);
        if ($district) {
            $site->setDistrict($district);
        }

        // Features & Threats parsing
        $this->mapFeatures($site, $dto->features);
        $this->mapThreats($site, $dto->threats);
        $site->setFeaturesRemarks($dto->features_r);

        // Excavations
        $site->setExcavationsWhomWhen($dto->excavation);
        $site->setExcavationsBibliography($dto->excavatio0);

        // Materialized view data (some fields are needed for it)
        $site->setCompiler($contribute->getEmail());
        $site->setCompilationDate(new \DateTime());

        // Geometries
        if ($dto->geometry) {
            $boundary = new SiteBoundaryEntity();
            $boundary->setSite($site);
            // Convert GeoJSON array to WKT for Doctrine
            $wkt = $this->geoJsonToWkt($dto->geometry);
            $boundary->setGeom($wkt);
            $site->setGeom($boundary);
        }

        // Chronologies
        $this->mapChronologies($site, $dto);

        // Surveys
        $this->mapSurveys($site, $dto->surveys);

        return $site;
    }

    private function mapFeatures(SiteEntity $site, ?string $featuresStr)
    {
        if (!$featuresStr) return;
        $f = array_map('trim', explode(';', $featuresStr));
        $site->setFeaturesEpigraphic(in_array('epigraphic', $f));
        $site->setFeaturesAncientStructures(in_array('ancient_structures', $f));
        $site->setFeaturesPaleochannels(in_array('paleochannels', $f));
    }

    private function mapThreats(SiteEntity $site, ?string $threatsStr)
    {
        if (!$threatsStr) return;
        $t = array_map('trim', explode(';', $threatsStr));
        $site->setThreatsNaturalDunes(in_array('natural_dunes', $t));
        $site->setThreatsLooting(in_array('looting', $t));
        $site->setThreatsCultivationTrenches(in_array('cultivation_trenches', $t));
        $site->setThreatsModernStructures(in_array('modern_structures', $t));
        $site->setThreatsModernCanals(in_array('modern_canals', $t));
        $site->setThreatsBulldozer(in_array('bulldozer', $t));
    }

    private function mapChronologies(SiteEntity $site, $dto)
    {
        if ($dto instanceof SurveyNotSampledFeatureDTO) {
            return;
        }

        // Use the resolver for the semicolon string
        $chronologies = $this->chronologyResolver->resolveFromSemicolonString($dto->chronology);
        foreach ($chronologies as $chron) {
            $sc = new SiteChronologyEntity();
            $sc->setSite($site);
            $sc->setChronology($chron);
            $site->addChronology($sc);
        }
    }

    private function mapSurveys(SiteEntity $site, ?string $surveysStr)
    {
        if (!$surveysStr) return;
        $surveys = $this->surveyResolver->resolveFromSemicolonString($surveysStr);
        foreach ($surveys as $survey) {
            $ss = new SiteSurveyEntity();
            $ss->setSite($site);
            $ss->setSurvey($survey);
            $site->addSurvey($ss);
        }
    }

    private function geoJsonToWkt(array $geometry): string
    {
        $type = strtoupper($geometry['type']);
        $coords = $geometry['coordinates'];

        switch ($type) {
            case 'MULTIPOLYGON':
                $polygons = [];
                foreach ($coords as $polygon) {
                    $rings = [];
                    foreach ($polygon as $ring) {
                        $points = [];
                        foreach ($ring as $pt) {
                            $points[] = $pt[0] . ' ' . $pt[1];
                        }
                        $rings[] = '(' . implode(',', $points) . ')';
                    }
                    $polygons[] = '(' . implode(',', $rings) . ')';
                }
                return 'SRID=4326;MULTIPOLYGON(' . implode(',', $polygons) . ')';
            default:
                throw new \InvalidArgumentException("Unsupported geometry type: $type");
        }
    }
}
