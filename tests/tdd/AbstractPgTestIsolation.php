<?php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractPgTestIsolation extends KernelTestCase
{
    use TestKernelUtilsTrait;
    /**
     * @var EntityManager[]
     */
    private $ems = [];

    protected function getEntityManager(string $em = 'default'): EntityManager
    {
        if (!array_key_exists($em, $this->ems)) {
            $this->ems[$em] = $this->getKernel()->getContainer()->get('doctrine')->getManager($em);
        }
        return $this->ems[$em];
    }

    protected function setUpDatabaseSchema(string $em = 'default')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->setAutoCommit(false);
        $connection->beginTransaction();
        $sql = \file_get_contents($this->getAbsolutePath('tests/assets/sql/tdd/db.sql'));
        $connection->exec($sql);
    }

    protected function rollbackDatabaseSchema(string $em = 'default')
    {
        $this->getEntityManager($em)->getConnection()->rollBack();
    }


}
