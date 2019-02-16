<?php

namespace App\Repository;

use App\Entity\VocChronologyEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class VocChronologyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VocChronologyEntity::class);
    }

    public function codeExists(string $code): bool
    {
        return (bool) $this->findOneBy(['code' => $code]);
    }
}
