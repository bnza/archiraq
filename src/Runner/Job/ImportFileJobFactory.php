<?php

namespace App\Runner\Job;

use Bnza\JobManagerBundle\Runner\JobFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportFileJobFactory
{
    /**
     * @var JobFactory;
     */
    private $factory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $baseWorkDir;

    public function __construct(
        JobFactory $factory,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        string $baseWorkDir
    ) {
        $this->factory = $factory;
        $this->validator = $validator;
        $this->em = $em;
        $this->baseWorkDir = $baseWorkDir;
    }

    public function create(string $jobClass, string $id = '', $params = [])
    {
        $p = array_merge(
            [
                'validator' => $this->validator,
                'entityManager' => $this->em,
                'workDir' => $this->baseWorkDir,
            ],
            $params
        );

        return $this->factory->create($jobClass, $id, $p);
    }
}
