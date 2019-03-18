<?php

namespace App\Repository;

use App\Entity\ContributeEntity;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContributeRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContributeEntity::class);
    }

    public function hasDraftErrors(int $id): bool
    {
        return (bool) $this->countDraftErrors($id);
    }

    public function countDraftErrors(int $id): int
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->select('COUNT(e)')
            ->innerJoin('c.drafts', 'd')
            ->innerJoin('d.errors', 'e')
            ->where('c.id = ?1')
            ->setParameter(1, $id)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

}
