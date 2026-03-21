<?php

namespace App\Service\Import;

use App\Entity\Geom\DistrictBoundaryEntity;
use Doctrine\ORM\EntityManagerInterface;

class DistrictResolver
{
    private $em;
    private $lookup = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function load()
    {
        if (!empty($this->lookup)) {
            return;
        }

        $entities = $this->em->getRepository(DistrictBoundaryEntity::class)->findAll();
        foreach ($entities as $entity) {
            $this->lookup[$entity->getId()] = $entity;
        }
    }

    public function resolve(?int $id): ?DistrictBoundaryEntity
    {
        if ($id === null) {
            return null;
        }

        $this->load();
        return $this->lookup[$id] ?? null;
    }
}
