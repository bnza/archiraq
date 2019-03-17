<?php

namespace App\Repository\Tmp;

use App\Entity\Tmp\DraftErrorEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DraftErrorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DraftErrorEntity::class);
    }

    public function getByContribute(int $id): array
    {
        $qb = $this->createQueryBuilder('e');
        $qb
            ->select('e')
            ->leftJoin('e.draft', 'd')
            ->leftJoin('d.contribute', 'c')
            ->where('c.id = ?1')
            ->setParameter(1, $id)
        ;

        return $qb->getQuery()->getResult();
    }
}