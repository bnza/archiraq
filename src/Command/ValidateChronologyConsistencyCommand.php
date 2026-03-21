<?php

namespace App\Command;

use App\DTO\SurveyFeatureDTO;
use App\Service\Import\GeoJsonlParser;
use App\Service\Import\GeoJsonlTypeDetector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ValidateChronologyConsistencyCommand extends Command
{
    protected static $defaultName = 'app:validate:chronology-consistency';

    private $parser;

    public function __construct(GeoJsonlParser $parser)
    {
        parent::__construct();
        $this->parser = $parser;
    }

    protected function configure()
    {
        $this
            ->setDescription('Compares the chronology semicolon-delimited string against the individual flag columns for SURVEY features.')
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

        $io->title("Validating Chronology Consistency for $file");

        $lineNumber = 0;
        $errorCount = 0;

        // Flags to check against the string
        $flags = [
            'UBA', 'UB12', 'UB3', 'LCA', 'LC13', 'LC45', 'JNA', 'LCJN', 'EDA', 'ED12', 
            'ED1', 'ED2', 'ED23', 'ED3', 'AKK_1', 'EBA', 'MBA', 'MB12', 'MB1', 'UR3', 
            'MB23', 'ILA', 'OBA', 'LBA', 'KAS1', 'KAS2', 'IRA', 'NB1', 'NB2', 'ACH', 
            'SEL', 'PART', 'PRSAS', 'ISLA', 'SAS', 'ISL1', 'ISL2', 'OTT'
        ];

        try {
            foreach ($this->parser->parse($file, GeoJsonlTypeDetector::TYPE_SURVEY) as $dto) {
                $lineNumber++;
                if (!$dto instanceof SurveyFeatureDTO) {
                    continue;
                }

                $codesFromString = array_filter(array_map('trim', explode(';', $dto->chronology)));
                
                $codesFromFlags = [];
                foreach ($flags as $flag) {
                    if ($dto->$flag === 'y' || $dto->$flag === '1' || $dto->$flag === 1) {
                        $codesFromFlags[] = $flag;
                    }
                }

                sort($codesFromString);
                sort($codesFromFlags);

                if ($codesFromString !== $codesFromFlags) {
                    $errorCount++;
                    $message = sprintf(
                        "Mismatch at line %d (ID: %s):\n String: [%s]\n Flags:  [%s]",
                        $lineNumber,
                        $dto->entry_id,
                        implode(', ', $codesFromString),
                        implode(', ', $codesFromFlags)
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
            $io->success("Consistency check passed for $lineNumber features.");
            return 0;
        } else {
            if ($exportFile) {
                file_put_contents($exportFile, implode("\n---\n", $errors));
                $io->note("Errors exported to $exportFile");
            }
            $io->error("Found $errorCount inconsistencies among $lineNumber features.");
            return 1;
        }
    }
}
