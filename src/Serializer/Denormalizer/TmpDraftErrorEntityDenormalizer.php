<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 10.42.
 */

namespace App\Serializer\Denormalizer;

use App\Entity\Tmp\DraftErrorEntity;

class TmpDraftErrorEntityDenormalizer extends AbstractEntityDenormalizer
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return $this->getDenormalizer()->denormalize($data, DraftErrorEntity::class, null, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return DraftErrorEntity::class === $type;
    }
}
