<?php

namespace App\Serializer;


use App\Entity\EntityInterface;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractEntityConverter
{
    use SerializerTrait;

    abstract protected function initSerializer(): Serializer;

    abstract public function getSourceClass(): string;

    abstract public function getTargetClass(): string;

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
     * @param array $context
     * @return EntityInterface
     */
    public function convert(EntityInterface $object, array $context = []): EntityInterface
    {
        $this->preNormalize($object, $context);
        $object = $this->getSerializer()->normalize($object, $this->getSourceClass(), $context);
        $this->preDenormalize($object, $context);
        return $this->getSerializer()->denormalize($object, $this->getTargetClass(), null, $context);
    }

    /**
     * @param EntityInterface $object
     * @param array $context
     */
    protected function preNormalize(EntityInterface $object, array &$context = []): void
    {}

    /**
     * @param array $object
     * @param array $context
     */
    protected function preDenormalize(array &$object, array &$context = []): void
    {}
}
