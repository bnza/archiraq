<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 07/02/19
 * Time: 20.36
 */

namespace App\Serializer\Denormalizer;


use App\Entity\SiteEntity;

class SiteEntityDenormalizer extends AbstractEntityDenormalizer
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (isset($data['compilationDate'])) {
            if (\is_string($data['compilationDate'])) {
                $data['compilationDate'] = \DateTime::createFromFormat('Y-m-d', \trim($data['compilationDate']));
            }
        }
        return $this->getDenormalizer()->denormalize($data, SiteEntity::class, null, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === SiteEntity::class;
    }
}
