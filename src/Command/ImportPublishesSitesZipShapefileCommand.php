<?php

namespace App\Command;

use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Bnza\JobManagerBundle\Command\AbstractJobSubscriberCommand;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Runner\Job\ImportPublishedSitesZipShapefileJob;

class ImportPublishesSitesZipShapefileCommand extends AbstractJobSubscriberCommand
{
    protected static $defaultName = 'app:import:sites-zip';

    /**
     * @var string
     */
    protected $baseWorkDir = '';

    public function __construct(ObjectManagerInterface $om, EventDispatcherInterface $dispatcher)
    {
        parent::__construct($om, $dispatcher);
    }

    public function configure()
    {
        $help = <<<'EOT'
Import a zip compressed shapefile into "public"."contribute" archiraq table assigning all entities to a new 
"public"."contribute" table entry with PENDING status
EOT;
        $this
            ->setDescription('Import a zip compressed shapefile into "public"."draft" archiraq table')
            ->setHelp($help)
            ->addArgument('path', InputArgument::REQUIRED, 'The zip path');
    }

    /**
     * @return string
     */
    public function getBaseWorkDir(): string
    {
        return $this->baseWorkDir;
    }

    /**
     * @param string $workDir
     */
    public function setWorkDir(string $workDir): void
    {
        if (!\file_exists($workDir)) {
            throw new \InvalidArgumentException("Base work directory MUST exists");
        }
        $this->baseWorkDir = $workDir;
    }

    protected function setUpJob(): JobInterface
    {
        $job = new ImportPublishedSitesZipShapefileJob($this->getObjectManager(), $this->getDispatcher(), '');
        $job->setWorkDir($this->getBaseWorkDir());
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->job = $this->setUpJob();
        parent::initialize($input, $output);
    }

    public function interact(InputInterface $input, OutputInterface $output)
    {

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
