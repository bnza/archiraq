<?php

namespace App\Serializer\Normalizer;

use App\Entity\Tmp\DraftEntity;

class TmpDraftEntityNormalizer extends AbstractEntityNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $data = $this->getNormalizer()->normalize($object, DraftEntity::class, $context);
        if ($data['ancientName']) {
            $name = $data['ancientName'];
            if ('?' === substr($name, 0, 1)) {
                $data['ancientName'] = substr($name, 1);
                $data['ancientNameUncertain'] = true;
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof DraftEntity;
    }
}
