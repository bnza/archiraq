<?php

namespace App\Command;

use App\Service\Import\GeoJsonlImporter;
use App\Event\ImportProgressEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportGeoJsonlCommand extends Command
{
    protected static $defaultName = 'app:import:geojsonl';

    private $importer;
    private $dispatcher;

    public function __construct(GeoJsonlImporter $importer, EventDispatcherInterface $dispatcher)
    {
        parent::__construct();
        $this->importer = $importer;
        $this->dispatcher = $dispatcher;
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports GeoJSONL site data.')
            ->addArgument('file', InputArgument::REQUIRED, 'The GeoJSONL file to import')
            ->addOption('type', null, InputOption::VALUE_OPTIONAL, 'SURVEY|SURVEY_NOT_SAMPLED|REMOTE_SENSING')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Validate without writing to database')
            ->addOption('batch-size', null, InputOption::VALUE_OPTIONAL, 'Flush every N records', 50)
            ->addOption('email', null, InputOption::VALUE_OPTIONAL, 'Contributor email')
            ->addOption('contributor', null, InputOption::VALUE_OPTIONAL, 'Contributor name')
            ->addOption('institution', null, InputOption::VALUE_OPTIONAL, 'Institution')
            ->addOption('description', null, InputOption::VALUE_OPTIONAL, 'Description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');
        $type = $input->getOption('type');
        $dryRun = $input->getOption('dry-run');
        $batchSize = (int)$input->getOption('batch-size');

        if (!file_exists($file)) {
            $io->error("File not found: $file");
            return 1;
        }

        // 1. Get/Prompt for Contribute Metadata
        $email = $input->getOption('email');
        if (!$email) {
            $email = $io->ask('Contributor email', null, function ($answer) {
                if (empty($answer)) throw new \RuntimeException('Email is required');
                return $answer;
            });
        }
        
        $contributor = $input->getOption('contributor') ?: $io->ask('Contributor name');
        $institution = $input->getOption('institution') ?: $io->ask('Institution');
        $description = $input->getOption('description') ?: $io->ask('Description');

        $metadata = [
            'email' => $email,
            'contributor' => $contributor,
            'institution' => $institution,
            'description' => $description,
        ];

        $io->title("Starting Import from $file");
        if ($dryRun) {
            $io->note("Dry-run mode: no changes will be saved.");
        }

        $this->dispatcher->addListener(ImportProgressEvent::REFRESH_STARTED, function (ImportProgressEvent $event) use ($io) {
            $io->newLine();
            $io->section($event->getMessage());
        });

        $this->dispatcher->addListener(ImportProgressEvent::REFRESH_FINISHED, function (ImportProgressEvent $event) use ($io) {
            $io->success($event->getMessage());
        });

        try {
            $result = $this->importer->import(
                $file,
                $type,
                $metadata,
                $dryRun,
                $batchSize,
                function() use ($io) {
                    $io->write(".");
                }
            );

            $io->newLine();
            $scanned = $result->count;
            $errorCount = count($result->errors);
            $io->note(sprintf('%d of %d entries scanned', $scanned, $scanned));
            if ($result->success) {
                if ($dryRun) {
                    $io->success("Dry-run finished. {$scanned} features validated.");
                } else {
                    $io->success("Imported {$scanned} features successfully.");
                }
                return 0;
            } else {
                $io->error(sprintf("Import failed with %d errors. Transaction rolled back.", $errorCount));
                $io->table(['Record', 'Error'], $result->errors);
                return 1;
            }
        } catch (\Exception $e) {
            $io->newLine();
            $io->error("Import failed: " . $e->getMessage());
            $io->note("Transaction rolled back.");
            return 1;
        }
    }
}
