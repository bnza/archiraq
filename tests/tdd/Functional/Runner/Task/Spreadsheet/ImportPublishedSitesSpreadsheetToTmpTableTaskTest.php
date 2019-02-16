<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 30/01/19
 * Time: 22.33.
 */

namespace App\Tests\Functional\Runner\Task\Spreadsheet;

use App\Runner\Task\Spreadsheet\ImportPublishedSitesSpreadsheetToTmpTableTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;

class ImportPublishedSitesSpreadsheetToTmpTableTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    /**
     * @var string
     */
    private $spreadsheetFileName;

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

    /**
     * @return MockObject|TaskInterface
     */
    protected function getTask(): ImportPublishedSitesSpreadsheetToTmpTableTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return ImportPublishedSitesSpreadsheetToTmpTableTask::class;
    }

    public function testConfigureWillCreateTempTable()
    {
        $this->spreadsheetFileName = 'site.xlsx';
        $this->setUpTask();
        $method = $this->getNonPublicMethod(ImportPublishedSitesSpreadsheetToTmpTableTask::class, 'configure');
        $method->invoke($this->getTask());
        $this->assertTemporaryTableExists("draft{$this->getJob()->getId()}");
    }

    public function testRunFillTempTable()
    {
        $this->spreadsheetFileName = 'site.xlsx';
        $this->runTask();
        $this->assertTemporaryTableRowsNum(5, "draft{$this->getJob()->getId()}");
    }

    protected function setUpAssets()
    {
        $this->copyAssetToTempDir('tdd/spreadsheet/'.$this->spreadsheetFileName, $this->spreadsheetFileName);
    }

    protected function callTaskSetters()
    {
        $this->getTask()->setEntityManager($this->getEntityManager());
        $this->getTask()->setSpreadsheetPath($this->getTestDir().DIRECTORY_SEPARATOR.$this->spreadsheetFileName);
    }
}
