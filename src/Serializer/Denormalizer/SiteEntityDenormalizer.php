<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 07/02/19
 * Time: 20.36.
 */

namespace App\Serializer\Denormalizer;

use App\Entity\SiteEntity;

class SiteEntityDenormalizer extends AbstractEntityDenormalizer
{
    use TypeConverterTrait;

    /**
     * {@inheritdoc}
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

        return $this->getDenormalizer()->denormalize($data, SiteEntity::class, null, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return SiteEntity::class === $type;
    }
}
