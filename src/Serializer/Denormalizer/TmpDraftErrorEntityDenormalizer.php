<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 10.42.
 */

namespace App\Serializer\Denormalizer;

use App\Entity\TmpDraftErrorEntity;

class TmpDraftErrorEntityDenormalizer extends AbstractEntityDenormalizer
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return $this->getDenormalizer()->denormalize($data, TmpDraftErrorEntity::class, null, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return TmpDraftErrorEntity::class === $type;
    }
}
