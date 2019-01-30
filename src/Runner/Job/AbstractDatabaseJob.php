<?php

namespace App\Runner\Job;


use Bnza\JobManagerBundle\Runner\Job\AbstractJob;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDatabaseJob extends AbstractJob
{
    public function getEntityManager(bool $throw = true): EntityManagerInterface
    {
        return $this->getParameter('em', $throw);
    }

    public function setEntityManager(EntityManagerInterface $em)
    {
        return $this->getParameters()->set('em', $em);
    }
}
