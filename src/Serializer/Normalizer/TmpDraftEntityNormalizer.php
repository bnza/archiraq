<?php

namespace App\Serializer\Normalizer;

use App\Entity\Tmp\DraftEntity;
use Doctrine\Common\Inflector\Inflector;

class TmpDraftEntityNormalizer extends AbstractEntityNormalizer
{
    private $attributes = [
      'id',
        'contribute',
        'errors',
        'entry_id',
        'remote_sensing',
        'modern_name',
        'ancient_name',
        'sbah_no',
        'cadastre',
        'site_chronology',
        'district',
        'features_epigraphic',
        'features_ancient_structures',
        'features_paleochannels',
        'features_remarks',
        'threats_natural_dunes',
        'threats_looting',
        'threats_cultivation_trenches',
        'threats_modern_structures',
        'threats_modern_canals',
        'threats_bulldozer',
        'survey_visit_date',
        'survey_verified_on_field',
        'survey_type',
        'survey_prev_refs',
        'compiler',
        'compilation_date',
        'remarks',
        'credits',
        'geom'
    ];

    private function _normalize(DraftEntity $object, array $context = []): array
    {
        $data = [];
        foreach ($this->attributes as $attribute) {
            $key = Inflector::camelize($attribute);
            $method = 'get'.ucfirst($key);
            $data[$key] = $object->$method();
        }
        return $data;
    }
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $data = $this->_normalize($object);
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
