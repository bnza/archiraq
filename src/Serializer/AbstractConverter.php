<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Serializer;

abstract class AbstractConverter
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
     * @param object $object
     * @param array  $context
     *
     * @return object
     */
    public function convert($object, array $context = [])
    {
        $this->preNormalize($object, $context);
        $object = $this->getSerializer()->normalize($object, $this->getSourceClass(), $context);
        $this->preDenormalize($object, $context);

        return $this->getSerializer()->denormalize($object, $this->getTargetClass(), null, $context);
    }

    /**
     * @param object $object
     * @param array  $context
     */
    protected function preNormalize($object, array &$context = []): void
    {
    }

    /**
     * @param array $object
     * @param array $context
     */
    protected function preDenormalize(array &$object, array &$context = []): void
    {
    }
}
