<?php

namespace App\Tests\Functional\Service\Import;

use App\Service\Import\DatabaseTruncator;
use App\Tests\Functional\AbstractPgTestIsolation;

class DatabaseTruncatorTest extends AbstractPgTestIsolation
{
    /** @var DatabaseTruncator */
    private $truncator;

    public static function setUpBeforeClass(): void
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->truncator = self::$container->get(DatabaseTruncator::class);
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }

    public function testTruncateAll()
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        
        // Site needs contribute and district.
        // District 48 exists in the dump.

        // 3. Truncate
        $this->truncator->truncateAll();

        // 4. Verify tables are empty
        $this->assertEquals(0, $connection->fetchColumn("SELECT COUNT(*) FROM public.site_chronology"));
        $this->assertEquals(0, $connection->fetchColumn("SELECT COUNT(*) FROM public.site_survey"));
        $this->assertEquals(0, $connection->fetchColumn("SELECT COUNT(*) FROM geom.site"));
        $this->assertEquals(0, $connection->fetchColumn("SELECT COUNT(*) FROM public.site"));
    }
}
