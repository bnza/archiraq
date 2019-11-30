<?php

namespace App\Tests\Functional\Runner\Task\Process;

use Bnza\JobManagerBundle\Event\JobEndedEvent;
use App\Runner\Task\Process\ImportShpToTmpTableTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;
use Doctrine\DBAL\FetchMode;

class ImportShpToTmpTableTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    private $shapeFolder;

    private $fields = [
        'verified',
        'nat_damage',
        'looting',
        'structures',
        'mod_channe',
        'bulldozer'
    ];

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
        $this->getTask()->getJob()->getDispatcher()->dispatch( new JobEndedEvent($this->getTask()->getJob()), JobEndedEvent::NAME);
        $this->assertTableNotExists($this->getTask()->getTableName());
    }

    public function testMethodRunWillInsertRowIntoTmpTable()
    {
        $this->shapeFolder = 'simple';
        $this->runTask();
        $this->assertTableRowsNum(1, $this->getTask()->getTableName());
    }

    public function testMethodRunWillInsertRowsIntoTmpTable()
    {
        $this->shapeFolder = 'rs';
        $this->runTask();
        $table = $this->getTask()->getTableName();
        $this->assertTableRowsNum(3, $table);

        $sql = "SELECT * FROM $table";
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql);

        /**
         * shapefile contains a row with string falsy values, a row with thruty ones and another with null values
         */
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $i =>$row) {
            $method = [
                'assertValueIsBoolFalsy',
                'assertValueIsBoolTruthy',
                'assertValueIsNull'
            ][$i];
            foreach ($this->fields as $key) {
                $this->$method($row[$key]);
            }
        }
    }

    private function assertValueIsBoolFalsy(string $value)
    {
        $this->assertNotContains($value, ['y','Y','yes','Yes','t','true']);
    }

    private function assertValueIsBoolTruthy(string $value)
    {
        $this->assertContains($value, ['y','Y','yes','Yes','t','true']);
    }

    private function assertValueIsNull(?string $value)
    {
        $this->assertNull($value);
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
