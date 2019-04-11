<?php

namespace App\Tests\Functional;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

trait PgTestIsolationTrait
{
    use TestKernelUtilsTrait;

    /**
     * @var EntityManager[]
     */
    private $ems = [];

    protected static function getContainerEntityManager(string $em = 'default'): EntityManager
    {
        $container =
            self::getKernel()->getContainer()
                ?: self::bootKernel()->getContainer();

        return $container->get('doctrine')->getManager($em);
    }

    protected function getEntityManager(string $em = 'default'): EntityManager
    {
        if (!array_key_exists($em, $this->ems)) {
            $this->ems[$em] = self::getContainerEntityManager($em);
        }

        return $this->ems[$em];
    }

    protected function getConnection(string $em = 'default'): Connection
    {
        return $this->getEntityManager($em)->getConnection();
    }

    protected static function beginMainTransaction(string $em = 'default'): Connection
    {
        $connection = self::getContainerEntityManager($em)->getConnection();
        $connection->setNestTransactionsWithSavepoints(true);
        $connection->setAutoCommit(false);
        $connection->beginTransaction();
        return $connection;
    }

    protected static function rollbackMainTransaction(string $em = 'default'): Connection
    {
        $connection = self::getContainerEntityManager($em)->getConnection();
        $connection->rollBack();
        $connection->setAutoCommit(true);
        return $connection;
    }

    protected static function setUpDatabaseSchema(string $em = 'default')
    {
        $sql = \file_get_contents(self::getAbsolutePath('tests/assets/tdd/sql/db.sql'));
        self::beginMainTransaction($em)->exec($sql);
    }

    protected static function rollbackDatabaseSchema(string $em = 'default')
    {
        self::rollbackMainTransaction($em);
    }

    protected function savepoint(string $em = 'default', string $savepoint = 'test')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->beginTransaction();
    }

    protected function rollbackSavepoint(string $em = 'default', string $savepoint = 'test')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->rollBack();
        $this->getEntityManager()->clear();
    }

    protected function executeSql(string $sql, string $em = 'default')
    {
        return $this->getConnection($em)->exec($sql);
    }

    /**
     *
     * @param string $path relativo to tests/assets
     *
     * @param string $em
     * @return int
     */
    protected function executeSqlAssetFile(string $path, string $em = 'default')
    {
        $path = $this->getAssetsDir().DIRECTORY_SEPARATOR.$path;
        $sql = \file_get_contents($path);

        return $this->executeSql($sql, $em);
    }
}
