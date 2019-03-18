<?php

namespace App\Repository\Voc;

use App\Entity\Voc\ChronologyEntity;
use App\Repository\AbstractCrudRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ChronologyRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChronologyEntity::class);
    }

    public function codeExists(string $code): bool
    {
        return (bool) $this->findOneBy(['code' => $code]);
    }
}
