<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RefreshMaterializedViewCommand extends Command
{
    protected static $defaultName = 'app:db:refresh-mat-view';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Refreshes the geom.mat_site materialized view.')
            ->addOption('view', null, InputOption::VALUE_OPTIONAL, 'The view to refresh', 'geom.mat_site');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $view = $input->getOption('view');

        $io->title("Refreshing Materialized View: $view");

        try {
            $connection = $this->em->getConnection();
            $connection->executeUpdate("REFRESH MATERIALIZED VIEW $view");
            $io->success("View $view refreshed successfully.");
            return 0;
        } catch (\Exception $e) {
            $io->error("Failed to refresh view $view: " . $e->getMessage());
            return 1;
        }
    }
}
