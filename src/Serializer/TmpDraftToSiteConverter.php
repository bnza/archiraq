<?php

namespace App\Serializer;


use App\Entity\EntityInterface;
use App\Entity\SiteEntity;
use App\Entity\TmpDraftEntity;
use App\Serializer\Denormalizer\SiteEntityDenormalizer;
use App\Serializer\Normalizer\TmpDraftEntityNormalizer;
use Symfony\Component\Serializer\Serializer;

class TmpDraftToSiteConverter extends AbstractEntityConverter
{
    use SerializerTrait;

    protected function initSerializer(): Serializer
    {
        return new Serializer([new TmpDraftEntityNormalizer(), new SiteEntityDenormalizer()]);
    }

    public function getSourceClass(): string
    {
        return TmpDraftEntity::class;
    }

    public function getTargetClass(): string
    {
        return SiteEntity::class;
    }

    /**
     * @param TmpDraftEntity $object
     * @param array $context
     */
    protected function preNormalize(EntityInterface $object, array &$context = []): void
    {
        $context['contribute'] = $object->getContribute();
    }

    protected function preDenormalize(array &$object, array &$context = []): void
    {
        $object['contribute'] = $context['contribute'];
    }
}
