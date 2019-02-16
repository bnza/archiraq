<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 10.44.
 */

namespace App\Serializer\Normalizer;

use Symfony\Component\Validator\ConstraintViolation;

class ConstraintViolationNormalizer extends AbstractEntityNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $data = [];
        $data['path'] = $object->getPropertyPath();
        $data['message'] = $object->getMessage();
        if (\array_key_exists('draft', $context)) {
            $data['draft'] = $context['draft'];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ConstraintViolation;
    }
}
