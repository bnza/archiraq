<?php

namespace App\Command;

use App\Service\Import\ChronologyResolver;
use App\Service\Import\GeoJsonlParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ValidateChronologyCodesCommand extends Command
{
    protected static $defaultName = 'app:validate:chronology-codes';

    private $parser;
    private $chronologyResolver;

    public function __construct(GeoJsonlParser $parser, ChronologyResolver $chronologyResolver)
    {
        parent::__construct();
        $this->parser = $parser;
        $this->chronologyResolver = $chronologyResolver;
    }

    protected function configure()
    {
        $this
            ->setDescription('Validates that every code in the chronology semicolon-delimited field resolves to a valid voc.chronology entry.')
            ->addArgument('file', InputArgument::REQUIRED, 'The GeoJSONL file to validate')
            ->addOption('export', null, InputOption::VALUE_REQUIRED, 'Export errors to a txt file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');
        $exportFile = $input->getOption('export');
        $errors = [];

        if (!file_exists($file)) {
            $io->error("File not found: $file");
            return 1;
        }

        $io->title("Validating Chronology Codes for $file");

        $lineNumber = 0;
        $errorCount = 0;

        try {
            foreach ($this->parser->parse($file) as $dto) {
                $lineNumber++;
                if ($dto->chronology === null) {
                    continue;
                }
                
                try {
                    $this->chronologyResolver->resolveFromSemicolonString($dto->chronology);
                } catch (\InvalidArgumentException $e) {
                    $errorCount++;
                    $message = sprintf(
                        "Line %d (ID: %s): %s",
                        $lineNumber,
                        $dto->entry_id,
                        $e->getMessage()
                    );
                    $errors[] = $message;
                    $io->warning($message);
                }
            }
        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return 1;
        }

        if ($errorCount === 0) {
            $io->success("Chronology code validation passed for $lineNumber features.");
            return 0;
        } else {
            if ($exportFile) {
                file_put_contents($exportFile, implode("\n", $errors));
                $io->note("Errors exported to $exportFile");
            }
            $io->error("Found $errorCount invalid chronology codes among $lineNumber features.");
            return 1;
        }
    }
}
