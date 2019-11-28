<?php

namespace App\Command\Job;


use App\Runner\Job\ImportSitesFromTmpDraftJob;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Bnza\JobManagerBundle\Command\AbstractJobListenerCommand;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class ImportSitesFromTmpDraftCommand extends AbstractJobListenerCommand
{
    use DatabaseTrait;
    use ValidatorTrait;
    use SummaryTrait;

    protected static $defaultName = 'app:import:tmp-draft';

    /**
     * @var int
     */
    protected $contributeId;

    public function __construct(
        ObjectManagerInterface $om,
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $em
    )
    {
        parent::__construct($om, $dispatcher);
        $this->em = $em;
    }

    public function configure()
    {
        $help = <<<'EOT'
Import "tmp"."draft" table's entries into "public"."site" table
EOT;
        $this
            ->setDescription('Import "tmp"."draft" table\'s entries into "public"."site" table')
            ->setHelp($help)
            ->addArgument('contribute', InputArgument::REQUIRED, 'The contribute id');
    }

    protected function setUpJob(): JobInterface
    {
        $job = new ImportSitesFromTmpDraftJob($this->getObjectManager(), $this->getDispatcher(), '');
        $job->setEntityManager($this->getEntityManager());
        $job->setValidator($this->getValidator());
        $job->setContribute($this->contributeId);

        return $job;
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->contributeId = $input->getArgument('contribute');
        $this->job = $this->setUpJob();
        parent::initialize($input, $output);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getJob()->run();
        return 0;
    }
}
