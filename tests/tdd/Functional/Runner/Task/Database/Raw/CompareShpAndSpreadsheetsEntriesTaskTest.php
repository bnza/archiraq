<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 31/01/19
 * Time: 20.50.
 */

namespace App\Tests\Functional\Runner\Task\Database\Raw;

use App\Runner\Task\Database\Raw\CompareShpAndSpreadsheetsEntriesTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;

class CompareShpAndSpreadsheetsEntriesTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    private $shpEntries;
    private $draftEntries;

    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->setUpBaseWorkDir();
        $this->setUpBaseOmDir();
    }

    public function tearDown()
    {
        $this->tearDownDir($this->getTestDir());
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function tablesEntryDataProvider()
    {
        return [
            [
                ['TES.001'],
                ['TES.001'],
                [],
                [],
            ],
            [
                ['TES.001', 'TES.002'],
                ['TES.001'],
                ['TES.002'],
                [],
            ],
            [
                ['TES.001'],
                ['TES.001', 'TES.002'],
                [],
                ['TES.002'],
            ],
            [
                ['TES.001', 'TES.003', 'TES.004'],
                ['TES.001', 'TES.002'],
                ['TES.003', 'TES.004'],
                ['TES.002'],
            ],
        ];
    }

    /**
     * @dataProvider tablesEntryDataProvider
     *
     * @param array $draftEntries
     * @param array $shpEntries
     * @param array $draftDiffs
     * @param array $shpDiffs
     */
    public function testTaskWillCompareTablesEntries(array $draftEntries, array $shpEntries, array $draftDiffs, array $shpDiffs)
    {
        $this->draftEntries = $draftEntries;
        $this->shpEntries = $shpEntries;
        $this->setUpTask();
        $this->fillShpTables();
        $this->fillDraftTable();
        $actual = $this->getTask()->getSpreadsheetDifference();
        $this->assertEquals(sort($draftDiffs), sort($actual), 'Spreadsheet diffs does not match');
        $this->assertEquals($shpDiffs, $this->getTask()->getShapefileDifference(), 'Shapefile diffs does not match');
    }

    /**
     * @return MockObject|CompareShpAndSpreadsheetsEntriesTask
     */
    protected function getTask(): CompareShpAndSpreadsheetsEntriesTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return CompareShpAndSpreadsheetsEntriesTask::class;
    }

    protected function setUpAssets()
    {
    }

    protected function fillDraftTable()
    {
        $id = $this->getTask()->getJob()->getId();
        $this->setUpDraftTable();
        $sql = <<<EOT
INSERT INTO "draft$id" (entry_id) VALUES (:id); 
EOT;
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        foreach ($this->draftEntries as $id) {
            $stmt->execute(['id' => $id]);
        }
    }

    protected function fillShpTables()
    {
        $id = $this->getTask()->getJob()->getId();
        $this->setUpShpTable();
        $sql = <<<EOT
INSERT INTO "tmp"."shp2pgsql$id" (id) VALUES (:id); 
EOT;
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        foreach ($this->shpEntries as $id) {
            $stmt->execute(['id' => $id]);
        }
    }

    protected function callTaskSetters()
    {
        $this->getTask()->setEntityManager($this->getEntityManager());
    }

    protected function setUpDraftTable()
    {
        $id = $this->getTask()->getJob()->getId();
        $sql = <<<EOT
CREATE TEMPORARY TABLE "draft$id" AS SELECT entry_id FROM "tmp"."draft" LIMIT 0; 
EOT;

        $this->getEntityManager()->getConnection()->exec($sql);
    }

    protected function setUpShpTable()
    {
        $id = $this->getTask()->getJob()->getId();
        $sql = <<<EOT
CREATE TABLE "tmp"."shp2pgsql$id" AS SELECT entry_id as id FROM "tmp"."draft" LIMIT 0; 
EOT;

        $this->getEntityManager()->getConnection()->exec($sql);
    }
}
