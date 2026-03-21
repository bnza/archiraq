<?php

namespace App\Command;

use App\Service\Import\DatabaseTruncator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TruncateSiteDataCommand extends Command
{
    protected static $defaultName = 'app:db:truncate-sites';

    private $truncator;

    public function __construct(DatabaseTruncator $truncator)
    {
        parent::__construct();
        $this->truncator = $truncator;
    }

    protected function configure()
    {
        $this
            ->setDescription('Truncates all site-related tables (site, site_chronology, site_survey, geom.site).')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force the operation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (!$input->getOption('force')) {
            $io->error('This operation is destructive. Use --force to proceed.');
            return 1;
        }

        $io->title('Truncating Site Data Tables');

        try {
            $this->truncator->truncateAll();
            $io->success('Site tables truncated successfully.');
            return 0;
        } catch (\Exception $e) {
            $io->error('Truncate failed: ' . $e->getMessage());
            return 1;
        }
    }
}
