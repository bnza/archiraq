<?php

namespace App\Service;

use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteChronologyEntity;
use App\Entity\SiteSurveyEntity;
use App\Serializer\Denormalizer\HttpDataSiteEntityDenormalizer;
use App\Service\HttpDataSiteChildrenUpdater;
use App\Entity\SiteEntity;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class HttpDataSiteUpdater extends AbstractHttpDataUpdater
{

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @var HttpDataSiteChildrenUpdater[]
     */
    private $childrenUpdaters = [];

    public function getDenormalizer(): DenormalizerInterface
    {
        if (!$this->denormalizer) {
            $this->denormalizer = new HttpDataSiteEntityDenormalizer($this->em);
        }

        return $this->denormalizer;
    }

    public function getChildrenUpdater(string $type): HttpDataSiteChildrenUpdater
    {
        if (!\array_key_exists($type, $this->childrenUpdaters)) {
            $this->childrenUpdaters[$type] = new HttpDataSiteChildrenUpdater($this->em, $type);
        }

        return $this->childrenUpdaters[$type];
    }

    /**
     * @param string $json
     *
     * @throws \Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function update(string $json)
    {
        $data = \json_decode($json, true);
        if (is_null($data)) {
            throw new \InvalidArgumentException('json data could not be parsed');
        }
        $this->em->beginTransaction();

        try {
            $geomData = $data['geom'];
            unset($data['geom']);
            $site = $this->mergeSite($data);
            $this->updateGeom($geomData, $site);
            $this->updateChildren($site, $data);
            $this->em->flush();
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

    private function mergeSite(array &$data): SiteEntity
    {
        $site = $this->getDenormalizer()->denormalize($data, SiteEntity::class);
        return $this->em->merge($site);
    }

    private function updateGeom(array $geomData, SiteEntity $site)
    {
        $geom = new SiteBoundaryEntity();
        $geom->setSite($site);
        $geom->setGeom($geomData['geom']);
        $this->em->merge($geom);
    }

    private function updateChildren(SiteEntity $site, array &$data)
    {
        foreach ([
                     'chronology',
                     'survey'
                 ] as $type) {
            $children = Inflector::pluralize($type);
            $this->getChildrenUpdater($type)->update($site, $data[$children]);
        }
    }
}
