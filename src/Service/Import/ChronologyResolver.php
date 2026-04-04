<?php

namespace App\Service\Import;

use App\Entity\Voc\ChronologyEntity;
use Doctrine\ORM\EntityManagerInterface;

class ChronologyResolver
{
    private $em;
    private $lookup = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function resetEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->lookup = []; // Force reload if needed, although IDs shouldn't change
    }

    private function load()
    {
        if (!empty($this->lookup)) {
            return;
        }

        $entities = $this->em->getRepository(ChronologyEntity::class)->findAll();
        foreach ($entities as $entity) {
            $this->lookup[$entity->getCode()] = $entity->getId();
        }
    }

    /**
     * @param string|null $chronologyString
     * @return ChronologyEntity[]
     * @throws \InvalidArgumentException
     */
    public function resolveFromSemicolonString(?string $chronologyString): array
    {
        if (empty($chronologyString)) {
            return [];
        }

        $this->load();
        $codes = array_filter(array_map('trim', explode(';', $chronologyString)));
        $resolved = [];

        foreach ($codes as $code) {
            if (!isset($this->lookup[$code])) {
                throw new \InvalidArgumentException("Unrecognized chronology code: $code");
            }
            $resolved[] = $this->em->getReference(ChronologyEntity::class, $this->lookup[$code]);
        }

        return $resolved;
    }

    public function resolveSingleCode(string $code): ?ChronologyEntity
    {
        $this->load();
        if (isset($this->lookup[$code])) {
            return $this->em->getReference(ChronologyEntity::class, $this->lookup[$code]);
        }
        return null;
    }
}
