<?php


namespace App\Serializer\Denormalizer;


use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

trait GetSetMethodNormalizerTrait
{
    /**
     * @var GetSetMethodNormalizer
     */
    private $getSetMethodDenormalizer;

    private function getGetSetMethodDenormalizer(): GetSetMethodNormalizer
    {
        if (!$this->getSetMethodDenormalizer) {
            $this->getSetMethodDenormalizer = new GetSetMethodNormalizer();
        }
        return $this->getSetMethodDenormalizer;
    }
}
