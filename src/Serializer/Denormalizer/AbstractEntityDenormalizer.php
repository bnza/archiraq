<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 07/02/19
 * Time: 20.19.
 */

namespace App\Serializer\Denormalizer;

use App\Serializer\SerializerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractEntityDenormalizer implements DenormalizerInterface
{
    use SerializerTrait;

    protected function initSerializer(): Serializer
    {
        return new Serializer([$this->getNormalizer(), $this->getDenormalizer()]);
    }
}
