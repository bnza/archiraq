<?php

namespace App\Command\Job;

use Doctrine\ORM\EntityManagerInterface;

trait DatabaseTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

}
