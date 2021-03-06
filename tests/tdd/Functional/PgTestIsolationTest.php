<?php

namespace App\Tests\Functional;

/**
 * @testdox The AbstractPgTestIsolation abstract class
 * Class PgTestIsolationTest
 */
class PgTestIsolationTest extends AbstractPgTestIsolation
{
    protected function getDatabaseSchemata(string $em = 'default'): array
    {
        $sql = 'SELECT schema_name FROM information_schema.schemata';
        $stmt = $this->getEntityManager($em)->getConnection()->query($sql);

        return $stmt->fetchAll(\Doctrine\DBAL\FetchMode::COLUMN);
    }

    protected function assertPreConditions()
    {
        $expected = ['pg_catalog', 'public', 'information_schema'];
        $actual = $this->getDatabaseSchemata();

        $this->assertEquals(\asort($expected), \asort($actual));
    }

    /**
     * @testdox setUpDatabaseSchema() will setup DB schemata
     */
    public function testSetUpDatabaseSchemaWillCreateSchemata()
    {
        self::setUpDatabaseSchema();
        $expected = ['pg_catalog', 'public', 'information_schema', 'geom', 'tmp', 'voc', 'admin'];
        $actual = $this->getDatabaseSchemata();
        $this->assertEquals(
            \asort($expected),
            \asort($actual)
        );
    }

    public function tearDown()
    {
        self::rollbackDatabaseSchema();
    }
}
