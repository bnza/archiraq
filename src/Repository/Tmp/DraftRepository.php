<?php

namespace App\Repository\Tmp;

use App\Entity\Tmp\DraftEntity;
use App\Repository\AbstractCrudRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DraftRepository extends AbstractCrudRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DraftEntity::class);
    }

    public function getByContribute(int $id): array
    {
        $qb = $this->createQueryBuilder('d');
        $qb
            ->select('d')
            ->where('d.contribute = ?1')
            ->setParameter(1, $id)
        ;
        return $qb->getQuery()->getResult();
    }

    public function getByContributeAsArray(int $id): array
    {
        $qb = $this->createQueryBuilder('d');
        $qb
            ->select('d')
            ->where('d.contribute = ?1')
            ->setParameter(1, $id)
        ;
        return $qb->getQuery()->getArrayResult();
    }

    public function countByContribute(int $id): int
    {
        $qb = $this->createQueryBuilder('d');
        $qb
            ->select('COUNT(d)')
            ->where('d.contribute = ?1')
            ->setParameter(1, $id)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }
}
