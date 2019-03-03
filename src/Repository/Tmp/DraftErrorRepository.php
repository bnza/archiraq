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
}
