<?php

namespace App\Repository\View;

use App\Entity\View\SiteEntity as VwSiteEntity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Repository\AbstractCrudRepository;

class SiteRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
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
