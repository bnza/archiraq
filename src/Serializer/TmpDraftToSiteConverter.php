<?php

namespace App\Serializer;

use App\Entity\EntityInterface;
use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteEntity;
use App\Entity\TmpDraftEntity;
use App\Serializer\Denormalizer\SiteEntityDenormalizer;
use App\Serializer\Normalizer\TmpDraftEntityNormalizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;

class TmpDraftToSiteConverter extends AbstractEntityConverter
{
    use SerializerTrait;
    use EntityManagerTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

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
     * @param EntityInterface $object
     * @param array           $context
     */
    protected function preNormalize($object, array &$context = []): void
    {
        $context['contribute'] = $object->getContribute();
    }

    protected function preDenormalize(array &$object, array &$context = []): void
    {
        $this->setSiteGeom($object);
        $object['district'] = $this->getEntityManager()->getRepository(DistrictBoundaryEntity::class)->findByName($object['district']);
        $object['contribute'] = $context['contribute'];
    }

    protected function setSiteGeom(array &$object)
    {
        $geom = new SiteBoundaryEntity();
        $geom->setGeom($object['geom']);
        $object['geom'] = $geom;
    }
}
