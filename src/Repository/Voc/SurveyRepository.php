<?php

namespace App\Repository\Voc;

use App\Entity\Voc\SurveyEntity;
use App\Repository\AbstractCrudRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class SurveyRepository extends AbstractCrudRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyEntity::class);
    }
}
