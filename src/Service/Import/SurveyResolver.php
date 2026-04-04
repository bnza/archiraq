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

    public function resetEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->lookup = [];
    }

    private function load()
    {
        if (!empty($this->lookup)) {
            return;
        }

        $entities = $this->em->getRepository(SurveyEntity::class)->findAll();
        foreach ($entities as $entity) {
            $this->lookup[$entity->getCode()] = $entity->getId();
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
                $survey = new SurveyEntity();
                $survey->setCode($code);
                $survey->setName($code);
                $survey->setRemarks('Auto-added during import');
                $this->em->persist($survey);
                $this->em->flush(); // Flush to get the ID if needed, though getReference usually needs it in lookup
                $this->lookup[$code] = $survey->getId();
            }
            $resolved[] = $this->em->getReference(SurveyEntity::class, $this->lookup[$code]);
        }

        return $resolved;
    }
}
