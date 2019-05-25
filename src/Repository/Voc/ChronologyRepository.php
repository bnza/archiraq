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

    public function getEntries(): array
    {
        return array_map(
            function ($entity) {
                /* @var ChronologyEntity $entity */
                return [
                    'id' => $entity->getId(),
                    'code' => $entity->getCode(),
                    'name' => $entity->getName(),
                    'date_low' => $entity->getDateLow(),
                    'date_high' => $entity->getDateHigh(),
                ];
            }, $this->findBy([], ['date_low' => 'ASC', 'date_high' => 'DESC']));
    }
}
