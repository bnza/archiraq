<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 11/02/19
 * Time: 10.57
 */

namespace App\Serializer;

use App\Entity\EntityInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

trait SerializerTrait
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * @var DenormalizerInterface
     */
    protected $denormalizer;

    abstract protected function initSerializer(): Serializer;


    /**
     * @return DenormalizerInterface
     */
    public function getDenormalizer(): DenormalizerInterface
    {
        if (!$this->denormalizer) {
            $this->denormalizer = $this->initDenormalizer();
            $this->getSerializer();
        }
        return $this->denormalizer;
    }

    /**
     * @return NormalizerInterface
     */
    public function getNormalizer(): NormalizerInterface
    {
        if (!$this->normalizer) {
            $this->normalizer = $this->initNormalizer();
            $this->getSerializer();
        }
        return $this->normalizer;
    }

    /**
     * @return Serializer
     */
    protected function getSerializer(): Serializer
    {
        if (!$this->serializer) {
            $this->serializer = $this->initSerializer();
        }
        return $this->serializer;
    }

    /**
     * @param EntityInterface $object
     * @param string|null $format
     * @param array $context
     * @return mixed
     */
    public function circularReferenceHandler(EntityInterface $object, string $format = null, array $context = [])
    {
        return $object->getId();
    }

    protected function initNormalizer(): GetSetMethodNormalizer
    {
        return new GetSetMethodNormalizer(
            null,
            null,
            null,
            null,
            null,
            ['circular_reference_handler' => [$this, 'circularReferenceHandler']]
        );
    }

    protected function initDenormalizer(): GetSetMethodNormalizer
    {
        return new GetSetMethodNormalizer(
            null,
            null,
            null,
            null,
            null,
            ['circular_reference_handler' => [$this, 'circularReferenceHandler']]
        );
    }
}
