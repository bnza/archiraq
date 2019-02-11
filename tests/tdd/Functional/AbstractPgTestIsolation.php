<?php

namespace App\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractPgTestIsolation extends KernelTestCase
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
        $connection->beginTransaction();
        $connection->createSavepoint('main');
        $sql = \file_get_contents(self::getAbsolutePath('tests/assets/tdd/sql/db.sql'));
        $connection->exec($sql);
    }

    protected static function rollbackDatabaseSchema(string $em = 'default')
    {
        $connection = self::getContainerEntityManager($em)->getConnection();
        $connection->rollbackSavepoint('main');
        $connection->rollBack();
        $connection->setAutoCommit(true);
    }

    protected function savepoint(string $em = 'default', string $savepoint = 'test')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->createSavepoint($savepoint);
    }

    protected function rollbackSavepoint(string $em = 'default', string $savepoint = 'test')
    {
        $connection = $this->getEntityManager($em)->getConnection();
        $connection->rollbackSavepoint($savepoint);
    }

    protected function executeSql(string $sql, string $em = 'default')
    {
        return $this->getConnection($em)->exec($sql);
    }

    /**
     * @param string $path
     * @return int
     */
    protected function executeSqlAssetFile(string $path, string $em = 'default')
    {
        $path = $this->getAssetsDir().DIRECTORY_SEPARATOR.$path;
        $sql = \file_get_contents($path);
        return $this->executeSql($sql);
    }

    protected function checkTableExists(string $table, string $schema = 'public', string $em = 'default')
    {
        if ($matches = $this->getTableIdentifiers($table)) {
            $schema = $matches['schema'];
            $table = $matches['table'];
        }
        $query = <<<EOF
SELECT EXISTS (
   SELECT 1
   FROM   information_schema.tables 
   WHERE  table_schema = :schema
   AND    table_name = :table
   );
EOF;
        $stmt = $this->getEntityManager($em)->getConnection()->prepare($query);
        $stmt->execute(['schema' => $schema, 'table' => $table]);

        return $stmt->fetchColumn();
    }

    protected function getTableIdentifiers(string $identifier): array
    {
        $identifiers = [];
        if (preg_match('/\"(?P<schema>.+)\".\"(?P<table>.+)\"/mU', $identifier, $matches)) {
            $identifiers['schema'] = $matches['schema'];
            $identifiers['table'] = $matches['table'];
        }

        return $identifiers;
    }

    protected function assertTableExists(string $table, string $schema = 'public', string $em = 'default')
    {
        $this->assertTrue($this->checkTableExists($table, $schema, $em), "Failed asserting that table \"$schema\".\"$table\" does exist");
    }

    protected function assertTableNotExists(string $table, string $schema = 'public', string $em = 'default')
    {
        $this->assertFalse($this->checkTableExists($table, $schema, $em), "Failed asserting that table \"$schema\".\"$table\" does not exist");
    }

    protected function checkTemporaryTableExists(string $table, string $em = 'default')
    {
        $query = <<<EOF
SELECT EXISTS (
   SELECT 1
   FROM   information_schema.tables 
   WHERE  table_type = 'LOCAL TEMPORARY'
   AND    table_name = :table
   );
EOF;
        $stmt = $this->getEntityManager($em)->getConnection()->prepare($query);
        $stmt->execute(['table' => $table]);

        return $stmt->fetchColumn();
    }

    protected function assertTemporaryTableExists(string $table, string $em = 'default')
    {
        $this->assertTrue($this->checkTemporaryTableExists($table, $em), "Failed asserting that temporary table \"$table\" does exist");
    }

    protected function assertTemporaryTableNotExists(string $table, string $em = 'default')
    {
        $this->assertFalse($this->checkTemporaryTableExists($table, $em), "Failed asserting that temporary table \"$table\" does exist");
    }

    protected function assertTableRowsNum(int $rows, string $table, string $schema = 'public', string $em = 'default')
    {
        if ($matches = $this->getTableIdentifiers($table)) {
            $schema = $matches['schema'];
            $table = $matches['table'];
        }
        $query = "SELECT COUNT(*) FROM \"$schema\".\"$table\";";
        $stmt = $this->getEntityManager($em)->getConnection()->prepare($query);
        $stmt->execute();
        $this->assertEquals($rows, $stmt->fetchColumn(), "Table \"$schema\".\"$table\" contains $rows row/s");
    }

    protected function assertTemporaryTableRowsNum(int $rows, string $table, string $em = 'default')
    {
        $query = "SELECT COUNT(*) FROM \"$table\";";
        $stmt = $this->getEntityManager($em)->getConnection()->prepare($query);
        $stmt->execute();
        $this->assertEquals($rows, $stmt->fetchColumn(), "Failed asserting that temporary table \"$table\" contains $rows row/s");
    }
}
