<?php

namespace App\Command\Job;


use App\Runner\Job\ValidateTmpDraftEntriesJob;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Bnza\JobManagerBundle\Command\AbstractJobListenerCommand;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class ValidateTmpDraftEntriesCommand extends AbstractJobListenerCommand
{
    use DatabaseTrait;
    use ValidatorTrait;
    use SummaryTrait;

    protected static $defaultName = 'app:validate:tmp-draft';

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
Validates "tmp"."draft" table's entries registering errors in "tmp"."draft_error" table
EOT;
        $this
            ->setDescription('Validates "tmp"."draft" table\'s entries')
            ->setHelp($help)
            ->addArgument('contribute', InputArgument::REQUIRED, 'The contribute id');
    }

    protected function setUpJob(): JobInterface
    {
        $job = new ValidateTmpDraftEntriesJob($this->getObjectManager(), $this->getDispatcher(), '');
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

    public function interact(InputInterface $input, OutputInterface $output)
    {
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getJob()->run();
        return 0;
    }
}
