<?php

namespace App\Tests\Functional\Runner\Task\Process;

use Bnza\JobManagerBundle\Event\JobEndedEvent;
use App\Runner\Task\Process\ImportShpToTmpTableTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;

class ImportShpToTmpTableTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    private $shapeFolder;

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

    public function testMethodRunWillCreateTmpTable()
    {
        $this->shapeFolder = 'simple';
        $this->runTask();
        $this->assertTableExists($this->getTask()->getTableName());
    }

    public function testTaskWillDropTmpTableOnJobEndedEvent()
    {
        $this->shapeFolder = 'simple';
        $this->runTask();
        $this->assertTableExists($this->getTask()->getTableName());
        $this->getTask()->getJob()->getDispatcher()->dispatch(JobEndedEvent::NAME, new JobEndedEvent($this->getTask()->getJob()));
        $this->assertTableNotExists($this->getTask()->getTableName());
    }

    public function testMethodRunWillInsertRowIntoTmpTable()
    {
        $this->shapeFolder = 'simple';
        $this->runTask();
        $this->assertTableRowsNum(1, $this->getTask()->getTableName());
    }

    /**
     * @return MockObject|TaskInterface
     */
    protected function getTask(): ImportShpToTmpTableTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return ImportShpToTmpTableTask::class;
    }

    protected function setUpAssets()
    {
        $originDir = $this->getAssetsDir()
            .DIRECTORY_SEPARATOR.'tdd'
            .DIRECTORY_SEPARATOR.'shp'
            .DIRECTORY_SEPARATOR.$this->shapeFolder;
        $targetDir = $this->getWorkDir($this->getJob()->getId());
        $this->getFilesystem()->mirror($originDir, $targetDir);
    }

    protected function callTaskSetters()
    {
        $workDir = $this->getWorkDir($this->getJob()->getId());
        $source = $workDir.DIRECTORY_SEPARATOR.$this->shapeFolder.'.shp';
        $this->getTask()->setSource($source);
        $this->getTask()->setEntityManager($this->getEntityManager());
    }
}
