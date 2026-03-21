<?php

namespace App\Service\Import;

use App\Entity\Voc\SurveyEntity;
use Doctrine\ORM\EntityManagerInterface;

class SurveyResolver
{
    private $em;
    private $lookup = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function load()
    {
        if (!empty($this->lookup)) {
            return;
        }

        $entities = $this->em->getRepository(SurveyEntity::class)->findAll();
        foreach ($entities as $entity) {
            $this->lookup[$entity->getCode()] = $entity;
        }
    }

    /**
     * @param string|null $surveysString
     * @return SurveyEntity[]
     * @throws \InvalidArgumentException
     */
    public function resolveFromSemicolonString(?string $surveysString): array
    {
        if (empty($surveysString)) {
            return [];
        }

        $this->load();
        $codes = array_filter(array_map('trim', explode(';', $surveysString)));
        $resolved = [];

        foreach ($codes as $code) {
            if (!isset($this->lookup[$code])) {
                throw new \InvalidArgumentException("Unrecognized survey code: $code");
            }
            $resolved[] = $this->lookup[$code];
        }

        return $resolved;
    }
}
