<?php

namespace App\Repository\Geom;

use App\Entity\Geom\DistrictBoundaryEntity;
use App\Repository\AbstractCrudRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DistrictBoundaryRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DistrictBoundaryEntity::class);
    }

    /**
     * @param string $name
     * @param bool   $insensitive
     *
     * @return DistrictBoundaryEntity
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName(string $name, bool $insensitive = true): DistrictBoundaryEntity
    {
        if ($insensitive) {
            $district = $this->createQueryBuilder('a')
                ->where('upper(a.name) = upper(:name)')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();
        } else {
            $district = $this->findOneBy(['name' => $name]);
        }

        return $district;
    }
}
