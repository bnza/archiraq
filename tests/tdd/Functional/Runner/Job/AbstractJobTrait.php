<?php

namespace App\Tests\Functional\Runner\Job;

use App\Tests\Functional\JobUtilsTrait;
use App\Tests\Functional\TestWorkDirTrait;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

trait AbstractJobTrait
{
    use TestWorkDirTrait;
    use JobUtilsTrait;

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var MockObject|JobInterface
     */
    protected $job;

    /**
     * Data provider
     * [
     *  [0] => (int) The upper step limit,
     *  [1] => (string) The assertion method to call after running
     * ]
     * @return array
     */
    abstract public function stepsDataAssertionsProvider(): array;

    /**
     * @return MockObject|JobInterface
     */
    abstract protected function getJob();

    abstract protected function getJobClassName(): string;

    abstract protected function setUpAssets();

    abstract protected function callJobSetters();

    /**
     * Test the job's steps up to the given limit and test the final status
     * @dataProvider stepsDataAssertionsProvider
     * @param int $limit
     * @param string $assertions
     */
    abstract public function testJobSteps(int $limit, string $assertions);

    /**
     * Test the job's steps up to the given limit and test the final status
     * @param int $limit
     * @param string $assertions
     */
    public function executeTestSteps(int $limit, string $assertions)
    {
        $this->setUpStepTest($this->getJobClassName(), $limit);
        $this->getJob()->run();
        $this->{$assertions}();
    }

    protected function setUpStepTest(string $className, int $limit = -1, array $constructorArgs = [])
    {
        $this->setUpAssets();
        $this->setUpMockedJob($className, $limit, $constructorArgs);
        $this->callJobSetters();
    }

    protected function setUpMockedJob(string $className, int $limit = -1, array $constructorArgs = [])
    {
        $this->om = new ObjectManager('dev', $this->getBaseOmDir());
        $this->dispatcher = new EventDispatcher();
        $this->job = $this->getMockWithMockedMethods($className, ['getSteps']);


        $steps = $this->getJobSteps($className, $this->job, $limit);
        $this->getJob()->method('getSteps')->willReturn($steps);

        $defaultConstructorArgs = [$this->om, $this->dispatcher, ''];
        $args = \array_merge($defaultConstructorArgs, $constructorArgs);
        $this->invokeConstructor($className, $this->job, $args);
    }

}
