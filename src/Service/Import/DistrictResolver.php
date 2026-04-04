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

    public function resetEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->lookup = [];
    }

    private function load()
    {
        if (!empty($this->lookup)) {
            return;
        }

        $entities = $this->em->getRepository(DistrictBoundaryEntity::class)->findAll();
        foreach ($entities as $entity) {
            $this->lookup[$entity->getId()] = $entity;
            if ($entity->getName()) {
                $this->lookup[strtolower($entity->getName())] = $entity;
            }
        }
    }

    public function resolve(?int $id, ?string $name = null): ?DistrictBoundaryEntity
    {
        if ($id === null && $name === null) {
            return null;
        }

        $this->load();

        if ($id !== null && isset($this->lookup[$id])) {
            return $this->lookup[$id];
        }

        if ($name !== null) {
            $nameKey = strtolower(trim($name));
            if (isset($this->lookup[$nameKey])) {
                return $this->lookup[$nameKey];
            }
        }

        return null;
    }
}
