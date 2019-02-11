<?php

namespace App\Serializer\Normalizer;

use App\Serializer\SerializerTrait;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

abstract class AbstractEntityNormalizer implements NormalizerInterface
{
    use SerializerTrait;

    protected function initSerializer(): Serializer
    {
        return new Serializer([$this->getNormalizer(), $this->getDenormalizer()]);
    }
}
