<?php

namespace App\Repository\View;

use App\Entity\View\SiteEntity as VwSiteEntity;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Repository\AbstractCrudRepository;

class SiteRepository extends AbstractCrudRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VwSiteEntity::class);
    }

    /**
     * {@inheritdoc}
     */
    public function addQueryBuilderLeftJoins(QueryBuilder $qb): AbstractCrudRepository
    {
        $qb->leftJoin('e.site', 'site');
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function addQueryBuilderSelects(QueryBuilder $qb): AbstractCrudRepository
    {
        $qb->addSelect('site');

        return $this;
    }
}
