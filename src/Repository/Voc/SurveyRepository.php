<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 01/03/19
 * Time: 16.21
 */

namespace App\Repository\Voc;

use App\Entity\Voc\SurveyEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyEntity::class);
    }
}
