<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 30/01/19
 * Time: 19.43
 */

namespace App\Runner\Task;

use Doctrine\ORM\EntityManagerInterface;

trait TaskEntityManagerTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    protected $schema = 'tmp';

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        if (!$this->em) {
            throw new \LogicException("You must set EntityManager before trying to get it");
        }
        return $this->em;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param string $schema
     */
    public function setSchema(string $schema): void
    {
        $this->schema = $schema;
    }

    protected function getDateStyle()
    {
        $sql = "SHOW DATESTYLE;";
        return $this->getEntityManager()->getConnection()->query($sql)->fetchColumn();
    }
}
