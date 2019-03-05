<?php

namespace App\Runner\Job;

use App\Entity\ContributeEntity;
use Bnza\JobManagerBundle\Runner\Job\ParameterBagTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

trait ContributeTrait
{
    abstract public function getParameters(): ParameterBag;

    abstract public function getEntityManager(bool $throw = true): EntityManagerInterface;

    public function setContribute($contribute)
    {
        if (is_numeric($contribute)) {
            $contribute = (int) $contribute;
        }
        if (!(is_int($contribute) || $contribute instanceof ContributeEntity)) {
            throw new \InvalidArgumentException("Invalid contribute " . gettype($contribute));
        }
        $this->getParameters()->set('contribute', $contribute);
    }

    public function getContribute(): ContributeEntity
    {
        $contribute = $this->getParameter('contribute');
        if (is_int($contribute)) {
            $id = $contribute;
            $contribute = $this->getEntityManager()->getRepository(ContributeEntity::class)->find($contribute);
            if (!$contribute) {
                throw new \InvalidArgumentException("No contribute found with id \"$id\"");
            }
            $this->setContribute($contribute);
        }
        return $contribute;
    }
}
