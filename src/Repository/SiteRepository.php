<?php

namespace App\Repository;

use App\Entity\SiteEntity;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SiteRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SiteEntity::class);
    }
}
