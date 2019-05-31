<?php


namespace App\Tests\Functional\Runner\Task\Database;

use App\Runner\Task\Database\DoctrineTransactionTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;
use Bnza\JobManagerBundle\Event\JobEndedEvent;
use PHPUnit\Framework\MockObject\MockObject;

class DoctrineTransactionTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    /**
     * @var int
     */
    private $nestingLevel;

    public static function setUpBeforeClass()
    {
        self::beginMainTransaction();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->setUpBaseOmDir();
        $this->nestingLevel = $this->getConnection()->getTransactionNestingLevel();
    }

    public function tearDown()
    {
        $this->tearDownDir($this->getTestDir());
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackMainTransaction();
    }

/*    public function assertPreConditions()
    {
        $this->assertEquals(3, $this->getEntityManager()->getConnection()->getTransactionNestingLevel());
    }*/

    public function testDoctrineTransactionTaskIncreasesTransactionNestingLevel()
    {
        $this->runTask();
        $this->assertEquals($this->nestingLevel + 1, $this->getEntityManager()->getConnection()->getTransactionNestingLevel());
        $this->getConnection()->rollBack();
    }

    public function testRollbackMethodWillRevertTransactionNestingLevel()
    {
        $this->runTask();
        $this->getTask()->rollback();
        $this->assertEquals($this->nestingLevel, $this->getEntityManager()->getConnection()->getTransactionNestingLevel());
    }

    public function testDispatchingJobEndedEventWillCallCommitMethod()
    {
        $this->runTask([], ['commit']);
        $task = $this->getTask();
        $task->expects($this->once())->method('commit');
        $task->getJob()->getDispatcher()->dispatch(new JobEndedEvent($task->getJob()), JobEndedEvent::NAME);
    }

    public function testDispatchingJobEndedEventWillRevertTransactionNestingLevel()
    {
        $this->runTask();
        $task = $this->getTask();
        $task->getJob()->getDispatcher()->dispatch(new JobEndedEvent($task->getJob()), JobEndedEvent::NAME);
        $this->assertEquals($this->nestingLevel, $this->getEntityManager()->getConnection()->getTransactionNestingLevel());
    }

    /**
     * @return MockObject|DoctrineTransactionTask
     */
    protected function getTask(): DoctrineTransactionTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return DoctrineTransactionTask::class;
    }

    protected function setUpAssets()
    {
    }

    protected function callTaskSetters()
    {
        $this->getTask()->setEntityManager($this->getEntityManager());
    }
}
