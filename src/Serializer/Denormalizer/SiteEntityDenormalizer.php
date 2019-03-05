<?php

namespace App\Serializer\Denormalizer;

use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Serializer\TmpDraftToSiteConverter;

class SiteEntityDenormalizer extends AbstractEntityDenormalizer
{
    use TypeConverterTrait;

    /**
     * {@inheritdoc}
     * @see TmpDraftToSiteConverter::preDenormalize()
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        foreach ([
                     'compilationDate' => ['date'],
                     'featuresEpigraphic' => ['boolean'],
                     'featuresAncientStructures' => ['boolean'],
                     'featuresPaleochannels' => ['boolean'],
                     'threatsNaturalDunes' => ['boolean'],
                     'threatsLooting' => ['boolean'],
                     'threatsCultivationTrenches' => ['boolean'],
                     'threatsModernStructures' => ['boolean'],
                     'threatsModernCanals' => ['boolean'],
                 ] as $key => $type) {
            $data[$key] = $this->cast($data[$key], ...$type);
        }

        $site = $this->getDenormalizer()->denormalize($data, SiteEntity::class, null, $context);

        if (\array_key_exists('site_chronology', $context)) {
            foreach ($context['site_chronology'] as $chronology) {
                if ($chronology) {
                    $siteChronology = new SiteChronologyEntity();
                    $siteChronology->setChronology($chronology);
                    $site->addChronology($siteChronology);
                }
            }
        }

        if (\array_key_exists('site_prev_refs', $context)) {
            foreach ($context['site_prev_refs'] as $survey) {
                $site->addSurvey($survey);
            }
        }

        return $site;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return SiteEntity::class === $type;
    }
}
