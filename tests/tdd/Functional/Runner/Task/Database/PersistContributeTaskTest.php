<?php

namespace App\Tests\Functional\Runner\Task\Database;

use App\Runner\Task\Database\PersistContributeTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;
use App\Entity\ContributeEntity;


class PersistContributeTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    /**
     * @var ContributeEntity
     */
    private $contribute;

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

    public function assertPreConditions()
    {
        $count = $this->getEntityManager()->getRepository(ContributeEntity::class)->count([]);
        $this->assertEquals(0, $count);
    }

    public function testMethodRunWillPersistContributeEntity()
    {
        $sha1 = sha1(microtime());
        $contribute = new ContributeEntity();
        $contribute->setSha1($sha1);
        $contribute->setEmail('email@example.com');
        $this->contribute = $contribute;
        $this->runTask();
        $count = $this->getEntityManager()->getRepository(ContributeEntity::class)->count([]);
        $this->assertEquals(1, $count);
        $count = $this->getEntityManager()->getRepository(ContributeEntity::class)->count(['sha1'=>$sha1]);
        $this->assertEquals(1, $count);
    }

    /**
     * @return MockObject|PersistContributeTask
     */
    protected function getTask(): PersistContributeTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return PersistContributeTask::class;
    }

    protected function setUpAssets()
    {

    }

    protected function callTaskSetters()
    {
        $this->getTask()->setEntityManager($this->getEntityManager());
        $this->getTask()->setContribute($this->contribute);
    }
}
