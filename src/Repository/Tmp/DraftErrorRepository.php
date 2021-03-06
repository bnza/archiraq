<?php

namespace App\Repository\Tmp;

use App\Entity\Tmp\DraftErrorEntity;
use App\Repository\AbstractCrudRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DraftErrorRepository extends AbstractCrudRepository
{
    public function __construct(ManagerRegistry $registry)
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
