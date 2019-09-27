<?php


namespace App\Serializer\Denormalizer;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerDenormalizerTrait
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
