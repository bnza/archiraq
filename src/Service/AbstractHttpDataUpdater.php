<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class AbstractHttpDataUpdater
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
