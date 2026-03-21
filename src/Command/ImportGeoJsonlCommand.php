<?php

namespace App\Command;

use App\Entity\ContributeEntity;
use App\Service\Import\FeatureDtoToEntityMapper;
use App\Service\Import\GeoJsonlParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportGeoJsonlCommand extends Command
{
    protected static $defaultName = 'app:import:geojsonl';

    private $em;
    private $parser;
    private $mapper;

    public function __construct(
        EntityManagerInterface $em,
        GeoJsonlParser $parser,
        FeatureDtoToEntityMapper $mapper
    ) {
        parent::__construct();
        $this->em = $em;
        $this->parser = $parser;
        $this->mapper = $mapper;
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

        $io->title("Starting Import from $file");
        if ($dryRun) {
            $io->note("Dry-run mode: no changes will be saved.");
        }

        $this->em->getConnection()->beginTransaction();

        try {
            $contribute = new ContributeEntity();
            $contribute->setEmail($email);
            if ($contributor) $contribute->setContributor($contributor);
            if ($institution) $contribute->setInstitution($institution);
            if ($description) $contribute->setDescription($description);
            $contribute->setStatus(1); // Assuming 1 means validated/imported
            $contribute->setSha1(sha1_file($file));

            if (!$dryRun) {
                $this->em->persist($contribute);
            }

            $count = 0;
            foreach ($this->parser->parse($file, $type) as $dto) {
                $count++;
                $site = $this->mapper->map($dto, $contribute);
                
                if (!$dryRun) {
                    $this->em->persist($site);
                    if ($count % $batchSize === 0) {
                        $this->em->flush();
                        $this->em->clear(App\Entity\SiteEntity::class);
                        $this->em->clear(App\Entity\SiteChronologyEntity::class);
                        $this->em->clear(App\Entity\SiteSurveyEntity::class);
                        $this->em->clear(App\Entity\Geom\SiteBoundaryEntity::class);
                        // Re-fetch or re-merge contribute if cleared
                        $contribute = $this->em->merge($contribute);
                    }
                }

                if ($count % 100 === 0) {
                    $io->write(".");
                }
            }

            if (!$dryRun) {
                $this->em->flush();
                $this->em->getConnection()->commit();
                
                $io->newLine();
                $io->section("Refreshing Materialized View");
                $this->em->getConnection()->executeUpdate("REFRESH MATERIALIZED VIEW geom.mat_site");
                
                $io->success("Imported $count features successfully.");
            } else {
                $this->em->getConnection()->rollBack();
                $io->newLine();
                $io->success("Dry-run finished. $count features validated.");
            }

            return 0;
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            $io->newLine();
            $io->error("Import failed: " . $e->getMessage());
            $io->note("Transaction rolled back.");
            return 1;
        }
    }
}
