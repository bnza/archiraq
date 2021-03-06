<?php
/**
 * Copyright (c) 2019.
 *
 * Author: Pietro Baldassarri
 *
 * For full license information see the README.md file
 */

namespace App\Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\MockBuilder;

trait MockUtilsTrait
{
    /**
     * @var MockObject|\Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $mockDispatcher;

    /**
     * @var MockObject|\Bnza\JobManagerBundle\Runner\Job\JobInterface
     */
    protected $mockJob;

    /**
     * @var MockObject[]|\Bnza\JobManagerBundle\Entity\JobEntityInterface[]
     */
    protected $mockJobEntity = [];

    /**
     * @var MockObject[]|\Bnza\JobManagerBundle\Entity\TaskEntityInterface[]
     */
    protected $mockTaskEntity = [];

    /**
     * @var MockObject[]|\Bnza\JobManagerBundle\Runner\Status[]
     */
    protected $mockStatus = [];

    /**
     * @var MockObject[]|\Bnza\JobManagerBundle\Runner\Task\TaskInterface[]
     */
    protected $mockTasks = [];

    /**
     * @var MockObject|\Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface
     */
    protected $mockOm;

    /**
     * @param $className
     *
     * @return MockBuilder
     */
    abstract public function getMockBuilder($className);

    /**
     * @param $originalClassName
     *
     * @return MockObject
     */
    abstract protected function createMock($originalClassName);

    /**
     * @param $originalClassName
     * @param array  $arguments
     * @param string $mockClassName
     * @param bool   $callOriginalConstructor
     * @param bool   $callOriginalClone
     * @param bool   $callAutoload
     * @param array  $mockedMethods
     * @param bool   $cloneArguments
     *
     * @return MockObject
     */
    abstract protected function getMockForAbstractClass($originalClassName, array $arguments = [], $mockClassName = '', $callOriginalConstructor = true, $callOriginalClone = true, $callAutoload = true, $mockedMethods = [], $cloneArguments = false);

    /**
     * @param $traitName
     * @param array  $arguments
     * @param string $mockClassName
     * @param bool   $callOriginalConstructor
     * @param bool   $callOriginalClone
     * @param bool   $callAutoload
     * @param array  $mockedMethods
     * @param bool   $cloneArguments
     *
     * @return MockObject
     */
    abstract protected function getMockForTrait($traitName, array $arguments = [], $mockClassName = '', $callOriginalConstructor = true, $callOriginalClone = true, $callAutoload = true, $mockedMethods = [], $cloneArguments = false);

    protected function getClassType(string $class): string
    {
        $rc = new \ReflectionClass($class);
        if ($rc->isInstantiable()) {
            return 'class';
        } else {
            if ($rc->isInterface()) {
                return 'interface';
            } elseif ($rc->isAbstract()) {
                return 'abstract';
            } elseif ($rc->isTrait()) {
                return 'trait';
            }
        }
    }

    protected function getMockWithMockedMethods(string $className, array $methods): MockObject
    {
        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods($methods ?: null)
            ->getMock();
    }

    protected function getMockForAbstractClassWithMockedMethods(string $className, array $methods): MockObject
    {
        return $this->getMockForAbstractClass(
            $className,
            [],
            '',
            false,
            true,
            true,
            $methods
        );
    }

    protected function getMockForTraitWithMockedMethods(string $className, array $methods): MockObject
    {
        return $this->getMockForTrait(
            $className,
            [],
            '',
            false,
            true,
            true,
            $methods
        );
    }

    protected function getMockForTypeWithMethods(string $className, array $methods): MockObject
    {
        $type = $this->getClassType($className);

        if ('interface' === $type) {
            $mock = $this->createMock($className);
        } elseif ('class' === $type) {
            $mock = $this->getMockWithMockedMethods($className, $methods);
        } elseif ('abstract' === $type) {
            $mock = $this->getMockForAbstractClassWithMockedMethods($className, $methods);
        } elseif ('trait' === $type) {
            $mock = $this->getMockForAbstractClassWithMockedMethods($className, $methods);
        } else {
            throw new \InvalidArgumentException("Invalid class type: $type");
        }

        return $mock;
    }

    /**
     * @param string $className
     * @param array  $methods
     *
     * @return MockObject|\Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface
     */
    protected function getMockObjectManager(
        $className = \Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface::class,
        $methods = []
    ): MockObject {
        $this->mockOm = $this->getMockForTypeWithMethods($className, $methods);

        return $this->mockOm;
    }

    /**
     * @param string $className
     * @param array  $methods
     *
     * @return MockObject|\Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getMockDispatcher(
        $className = \Symfony\Component\EventDispatcher\EventDispatcher::class,
        $methods = []
    ): MockObject {
        $this->mockDispatcher = $this->getMockForTypeWithMethods($className, $methods);

        return $this->mockDispatcher;
    }

    /**
     * @param string $className
     * @param array  $methods
     *
     * @return MockObject|\Bnza\JobManagerBundle\Runner\Job\JobInterface
     */
    protected function getMockJob(
        $className = \Bnza\JobManagerBundle\Runner\Job\JobInterface::class,
        $methods = []
    ): MockObject {
        $this->mockJob = $this->getMockForTypeWithMethods($className, $methods);

        return $this->mockJob;
    }

    /**
     * @param string $className
     * @param array  $methods
     * @param int    $index
     *
     * @return MockObject|\Bnza\JobManagerBundle\Runner\Task\TaskInterface
     */
    protected function getMockTask(
        $className = \Bnza\JobManagerBundle\Runner\Task\TaskInterface::class,
        $methods = [],
        $index = 0
    ): MockObject {
        $mock = $this->mockTasks[$index] = $this->getMockForTypeWithMethods($className, $methods);

        return $mock;
    }

    /**
     * @param string $className
     * @param array  $methods
     * @param int    $index
     *
     * @return MockObject|\Bnza\JobManagerBundle\Runner\Task\TaskInterface
     */
    protected function getMockTaskWithMockedJob(
        $className = \Bnza\JobManagerBundle\Runner\Task\TaskInterface::class,
        $methods = [],
        $index = 0,
        \Bnza\JobManagerBundle\Runner\Job\JobInterface $mockJob = null
    ): MockObject {
        $methods = \array_merge(['getJob'], $methods);
        $mock = $this->getMockTask($className, $methods, $index);
        if (!$mockJob) {
            $id = sha1(microtime());
            $mockJob = $this->getMockJob(\Bnza\JobManagerBundle\Runner\Job\JobInterface::class);
            $mockJob->method('getId')->willReturn($id);
        }
        $mock->method('getJob')->willReturn($mockJob);

        return $mock;
    }

    /**
     * @param string $className
     * @param array  $methods
     * @param int    $index
     *
     * @return MockObject|\Bnza\JobManagerBundle\Entity\JobEntityInterface
     */
    protected function getMockJobEntity(
        $className = \Bnza\JobManagerBundle\Entity\JobEntityInterface::class,
        $methods = [],
        $index = 0
    ): MockObject {
        $mock = $this->mockJobEntity[$index] = $this->getMockForTypeWithMethods($className, $methods);

        return $mock;
    }

    /**
     * @param string $className
     * @param array  $methods
     * @param int    $index
     *
     * @return MockObject|\Bnza\JobManagerBundle\Entity\TaskEntityInterface
     */
    protected function getMockTaskEntity(
        $className = \Bnza\JobManagerBundle\Entity\TaskEntityInterface::class,
        $methods = [],
        $index = 0
    ): MockObject {
        $mock = $this->mockJobEntity[$index] = $this->getMockForTypeWithMethods($className, $methods);

        return $mock;
    }

    /**
     * @param string $className
     * @param array  $methods
     * @param int    $index
     *
     * @return MockObject|\Bnza\JobManagerBundle\Runner\Status
     */
    protected function getMockStatus(
        $className = \Bnza\JobManagerBundle\Runner\Status::class,
        $methods = [],
        $index = 0
    ): MockObject {
        $mock = $this->mockStatus[$index] = $this->getMockForTypeWithMethods($className, $methods);

        return $mock;
    }

    protected function invokeConstructor(string $class, MockObject $object, array $arguments): void
    {
        $rc = new \ReflectionClass($class);
        $constructor = $rc->getConstructor();
        $constructor->invokeArgs($object, $arguments);
    }

    public function getMockTaskAndInvokeConstructor(string $class, array $specificArgs = [], array $baseArgs = [], array $methods = [], int $index = 0): MockObject
    {
        $mockTask = $this->getMockTask($class, $methods, $index);

        if (!isset($baseArgs[0])) {
            $baseArgs[0] = $this->mockOm ?: $this->getMockObjectManager();
        }
        if (!isset($baseArgs[1])) {
            $baseArgs[1] = $this->mockJob ?: $this->getMockJob();
        }
        if (!isset($baseArgs[2])) {
            $baseArgs[2] = (int) mt_rand(0, 100);
        }

        $this->invokeConstructor($class, $mockTask, \array_merge($baseArgs, $specificArgs));

        return $mockTask;
    }

    /**
     * Replaces string placeholder (e.g. '**mockJob**' or '**mockTask[0]**') with the corresponding mocked object
     * stored as object property (e.g. $this->mockObject or $this->mockTask[0]).
     *
     * @param array $data
     *
     * @return array
     */
    protected function replacePlaceholderWithMockedObject(array $data): array
    {
        $pattern = '/^\*\*(?P<object>\w+)(?>\[(?P<index>\d+)\])?\*\*$/';
        foreach ($data as $key => $datum) {
            if (\is_array($datum)) {
                $data[$key] = $this->replacePlaceholderWithMockedObject($datum);
            } else {
                if (\is_string($datum)) {
                    if (preg_match($pattern, $datum, $matches)) {
                        $datum = $this->{$matches['object']};
                        if (isset($matches['index'])) {
                            $datum = $datum[$matches['index']];
                        }
                        $data[$key] = $datum;
                    }
                }
            }
        }

        return $data;
    }

    protected function getStepAtIndex(iterable $steps, int $index): array
    {
        foreach ($steps as $i => $step) {
            if ($i === $index) {
                return $step;
            }
        }
    }

    /**
     * Get a private or protected method for testing/documentation purposes.
     * How to use for MyClass->foo():
     *      $cls = new MyClass();
     *      $foo = PHPUnitUtil::getPrivateMethod($cls, 'foo');
     *      $foo->invoke($cls, $...);.
     *
     * @param object|string $obj  The instantiated instance of your class
     * @param string        $name The name of your private/protected method
     *
     * @return \ReflectionMethod The method you asked for
     *
     * @throws \ReflectionException
     */
    private static function getNonPublicMethod($obj, $name)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
