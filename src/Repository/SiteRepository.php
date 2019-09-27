<?php

namespace App\Repository;

use App\Entity\SiteEntity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SiteRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SiteEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractCrudRepository
    {
        $qb->leftJoin('e.chronologies', 'chronologies');
        $qb->leftJoin('e.contribute', 'contribute');
        $qb->leftJoin('chronologies.chronology', 'voc_chronology');
        $qb->leftJoin('e.surveys', 'surveys');
        $qb->leftJoin('surveys.survey', 'voc_survey');
        $qb->leftJoin('e.district', 'district');
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractCrudRepository
    {
        $qb->addSelect('chronologies');
        $qb->addSelect('voc_chronology');
        $qb->addSelect('surveys');
        $qb->addSelect('voc_survey');
        $qb->addSelect('district');
        $qb->addSelect('contribute');
        return $this;
    }
}
