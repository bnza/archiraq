<?php

namespace App\Tests\Functional\Command;

use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

trait CommandUtilsTrait
{
    /**
     * @var ObjectManagerInterface
     */
    protected $om;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;


    abstract function getBaseOmDir(): string;

    abstract function setCommandParameters(Command $command): void;

    protected function executeCommandTester(string $name, array $input = [], array $options = []): CommandTester
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find($name);
        $commandTester = new CommandTester($command);

        $defaultInput = [
            'command' => $name,
        ];
        // Force ConsoleOutput
        $defaultOptions = [
            'capture_stderr_separately' => true,
        ];

        $input = \array_merge($input, $defaultInput);
        $options = \array_merge($options, $defaultOptions);

        if (\method_exists($this, 'getEntityManager')) {
            $command->setEntityManager($this->getEntityManager());
        }

        $commandTester->execute($input, $options);

        return $commandTester;
    }
}
