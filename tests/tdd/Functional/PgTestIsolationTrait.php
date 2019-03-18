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

    protected static function setUpDatabaseSchema(string $em = 'default')
    {
        $connection = self::getContainerEntityManager($em)->getConnection();
        $connection->setAutoCommit(false);
        $connection->exec('BEGIN TRANSACTION');
        $connection->exec('SAVEPOINT main');
        $sql = \file_get_contents(self::getAbsolutePath('tests/assets/tdd/sql/db.sql'));
        $connection->exec($sql);
    }

    protected static function rollbackDatabaseSchema(string $em = 'default')
    {
        $connection = self::getContainerEntityManager($em)->getConnection();
        $connection->exec('ROLLBACK TO SAVEPOINT main');
        $connection->exec('ROLLBACK');
    }

    protected function savepoint(string $em = 'default', string $savepoint = 'test')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->exec("SAVEPOINT \"$savepoint\"");
    }

    protected function rollbackSavepoint(string $em = 'default', string $savepoint = 'test')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->exec("ROLLBACK TO SAVEPOINT \"$savepoint\"");
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