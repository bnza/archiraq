<?php

namespace App\Tests\Functional\Runner\Task;

use App\Tests\Functional\TestWorkDirTrait;
use App\Tests\Unit\MockUtilsTrait;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

trait AbstractMockTrait
{
    use MockUtilsTrait;
    use TestWorkDirTrait;

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var MockObject|TaskInterface
     */
    protected $task;

    /**
     * @var MockObject|JobInterface
     */
    protected $job;

    /**
     * @return MockObject|TaskInterface
     */
    abstract protected function getTask();

    abstract protected function getTaskClassName(): string;

    abstract protected function setUpAssets();

    abstract protected function callTaskSetters();

    protected function getJob(): JobInterface
    {
        return $this->job;
    }

    protected function setUpMockedTask(string $className, array $constructorArgs = [], array $mockedMethods = [])
    {
        $id = sha1(microtime());
        $this->om = new ObjectManager('dev', $this->getBaseOmDir());
        $this->dispatcher = new EventDispatcher();
        $this->job = $this->getMockJob(JobInterface::class);

        $this->getJob()->method('getId')->willReturn($id);
        $this->getJob()->method('getDispatcher')->willReturn($this->dispatcher);

        $this->setUpOmJobDir($id);

        $this->task = $this->getMockWithMockedMethods($className, $mockedMethods);

        $defaultConstructorArgs = [$this->om, $this->job, 0];
        $args = \array_merge($defaultConstructorArgs, $constructorArgs);
        $this->invokeConstructor($className, $this->task, $args);
    }

    protected function setUpTask(array $constructorArgs = [], array $mockedMethods = [])
    {
        $this->setUpMockedTask($this->getTaskClassName(), $constructorArgs, $mockedMethods);
        $this->setUpAssets();
        $this->callTaskSetters();
    }

    protected function runTask(array $constructorArgs = [], array $mockedMethods = [])
    {
        $this->setUpTask($constructorArgs, $mockedMethods);
        $this->getTask()->run();
    }
}
