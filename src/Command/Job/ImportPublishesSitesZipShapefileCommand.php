<?php

namespace App\Command\Job;

use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Bnza\JobManagerBundle\Command\AbstractJobListenerCommand;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Runner\Job\ImportPublishedSitesZipShapefileJob;

class ImportPublishesSitesZipShapefileCommand extends AbstractJobListenerCommand
{
    use DatabaseTrait;
    use WorkDirTrait;
    use SummaryTrait;

    protected $path = '';

    protected static $defaultName = 'app:import:sites-zip';

    public function __construct(ObjectManagerInterface $om, EventDispatcherInterface $dispatcher, EntityManagerInterface $em)
    {
        parent::__construct($om, $dispatcher);
        $this->em = $em;
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

    protected function setUpJob(): JobInterface
    {
        $job = new ImportPublishedSitesZipShapefileJob($this->getObjectManager(), $this->getDispatcher(), '');
        $job->setWorkDir($this->getBaseWorkDir());
        $job->setEntityManager($this->getEntityManager());
        $job->setSourceZipShapefilePath($this->path);

        return $job;
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->path = $input->getArgument('path');
        $this->job = $this->setUpJob();
        parent::initialize($input, $output);
    }

    public function interact(InputInterface $input, OutputInterface $output)
    {
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getJob()->run();
    }
}