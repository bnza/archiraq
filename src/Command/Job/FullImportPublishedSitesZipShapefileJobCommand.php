<?php

namespace App\Command\Job;

use Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Bnza\JobManagerBundle\Command\AbstractJobListenerCommand;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Runner\Job\FullImportPublishedSitesZipShapefileJob;

class FullImportPublishedSitesZipShapefileJobCommand extends AbstractJobListenerCommand
{
    use DatabaseTrait;
    use WorkDirTrait;
    use SummaryTrait;
    use ValidatorTrait;

    protected $path = '';

    protected static $defaultName = 'app:import:full-sites-zip';

    public function __construct(ObjectManagerInterface $om, EventDispatcherInterface $dispatcher, EntityManagerInterface $em)
    {
        parent::__construct($om, $dispatcher);
        $this->em = $em;
    }

    public function configure()
    {
        $help = <<<'EOT'
Import a zip compressed shapefile into "public"."site" archiraq table assigning all entities to a new 
"public"."contribute" table entry with PENDING status
EOT;
        $this
            ->setDescription('Import a zip compressed shapefile into "public"."site" archiraq table')
            ->setHelp($help)
            ->addArgument('path', InputArgument::REQUIRED, 'The zip path');
    }

    protected function setUpJob(): JobInterface
    {
        $job = new FullImportPublishedSitesZipShapefileJob($this->getObjectManager(), $this->getDispatcher(), '');
        $job->setWorkDir($this->getBaseWorkDir());
        $job->setEntityManager($this->getEntityManager());
        $job->setSourceZipShapefilePath($this->path);
        $job->setValidator($this->getValidator());

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
        return 0;
    }
}
