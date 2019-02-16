<?php

namespace App\Repository;

use App\Entity\TmpDraftErrorEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TmpDraftErrorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TmpDraftErrorEntity::class);
    }
}
