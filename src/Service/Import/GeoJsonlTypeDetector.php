<?php

namespace App\Service\Import;

use App\DTO\RemoteSensingFeatureDTO;
use App\DTO\SurveyFeatureDTO;
use App\DTO\SurveyNotSampledFeatureDTO;

class GeoJsonlTypeDetector
{
    const TYPE_SURVEY = 'SURVEY';
    const TYPE_SURVEY_NOT_SAMPLED = 'SURVEY_NOT_SAMPLED';
    const TYPE_REMOTE_SENSING = 'REMOTE_SENSING';

    public function detect(array $firstFeature): string
    {
        $properties = $firstFeature['properties'] ?? [];

        if (isset($properties['survey_typ']) && $properties['survey_typ'] === 'not_sampled') {
            return self::TYPE_SURVEY_NOT_SAMPLED;
        }

        // SURVEY and REMOTE_SENSING have similar schemas, but SURVEY has individual flag columns like 'PART', 'SAS', 'ISLA'
        // Let's check for some specific SURVEY flags that are unlikely in RS
        $surveyFlags = ['UBA', 'LCA', 'PART', 'SAS', 'ISLA'];
        foreach ($surveyFlags as $flag) {
            if (array_key_exists($flag, $properties)) {
                return self::TYPE_SURVEY;
            }
        }

        return self::TYPE_REMOTE_SENSING;
    }

    public function getDtoClass(string $type): string
    {
        switch ($type) {
            case self::TYPE_SURVEY:
                return SurveyFeatureDTO::class;
            case self::TYPE_SURVEY_NOT_SAMPLED:
                return SurveyNotSampledFeatureDTO::class;
            case self::TYPE_REMOTE_SENSING:
                return RemoteSensingFeatureDTO::class;
            default:
                throw new \InvalidArgumentException("Unknown import type: $type");
        }
    }
}
