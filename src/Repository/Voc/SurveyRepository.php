<?php

namespace App\Repository\Voc;

use App\Entity\Voc\SurveyEntity;
use App\Repository\AbstractCrudRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class SurveyRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyEntity::class);
    }

    public function filterByCodeStartWith(string $pattern, int $limit = 10): array
    {
        $qb = $this->createQueryBuilder('s')
            ->setMaxResults($limit);
        $qb
            ->where($qb->expr()->like('s.code', ':code'))
            ->orderBy('s.code');
        $code = strtoupper($pattern.'%');
        $qb->setParameter('code', $code);
        return $qb->getQuery()->getArrayResult();
    }


}
