<?php

namespace App\Repository\Tmp;

use App\Entity\Tmp\DraftEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DraftRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DraftEntity::class);
    }

    public function getByContribute(int $id): array
    {
        $qb = $this->createQueryBuilder('d');
        $qb
            ->select('d')
            ->innerJoin('d.contribute', 'c')
            ->where('c.id = ?1')
            ->setParameter(1, $id)
        ;
        return $qb->getQuery()->getResult();
    }
}
