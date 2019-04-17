<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use Bnza\JobManagerBundle\Event\SummaryEntryEvent;
use Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException;
use Bnza\JobManagerBundle\Summary\Entry\ErrorEntry;
use Symfony\Component\Serializer\Serializer;
use App\Serializer\Normalizer\TmpDraftEntityNormalizer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use Doctrine\Common\Inflector\Inflector;

class ValidateTmpDraftEntriesTaskToCsv extends AbstractValidateTmpDraftEntriesTask
{
    const ERROR_COLUMN = 'M';

    /**
     * @var int
     */
    private $spreadsheetRowIndex = 0;

    /**
     * @var Spreadsheet
     */
    private $spreadsheet;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Inflector
     */
    private $inflector;

    /**
     * @var string
     */
    private $validationCsvFilePath;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:validate-tmp-draft-to-csv';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Validating temporary draft entities ("tmp"."draft") to CSV';
    }

    /**
     * Persists constraint validation errors to DB.
     *
     * @param DraftEntity $draft
     * @param $errors
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function persistErrors(DraftEntity $draft, $errors)
    {
        $this->draftContainsErrors = true;
        $worksheet = $this->getSpreadsheet()->getActiveSheet();
        $rowIndex = ++$this->spreadsheetRowIndex;
        $this->persistRowValues($draft, $rowIndex);
        $coord = self::ERROR_COLUMN.$rowIndex;
        $worksheet->getCell($coord)->setValue((string) $errors);
    }

    protected function persistRowValues(DraftEntity $draft, int $rowIndex)
    {
        $worksheet = $this->getSpreadsheet()->getActiveSheet();
        $values = $this->getSerializer()->normalize($draft);
        foreach ($this->getExpectedHeaders() as $key => $field) {
            $coord = $key.$rowIndex;
            $field = Inflector::camelize($field);
            $value = $values[$field];
            $worksheet->getCell($coord)->setValue($value);
        }
    }

    protected function getSerializer(): Serializer
    {
        if (!$this->serializer) {
            $this->serializer = new Serializer([new TmpDraftEntityNormalizer()]);
        }

        return $this->serializer;
    }

    /**
     * @throws JobManagerNonCriticalErrorException
     */
    public function terminate(): void
    {
        if ($this->draftContainsErrors) {
            $this->writeCurrentWorksheet($this->getSpreadsheet());
            $entry = new ErrorEntry($this, 'Draft validation failed');
            $event = new SummaryEntryEvent($entry);
            $this->getJob()->getDispatcher()->dispatch(SummaryEntryEvent::NAME, $event);
            throw new JobManagerNonCriticalErrorException($entry->getMessage());
        }
    }

    public function setValidationCsvFilePath(string $shpPath)
    {
        $this->validationCsvFilePath = \dirname($shpPath).DIRECTORY_SEPARATOR.'validationErrors.csv';
    }

    public function getValidationCsvFilePath(): string
    {
        return $this->validationCsvFilePath;
    }

    protected function getSpreadsheet(): Spreadsheet
    {
        if (!$this->spreadsheet) {
            $this->spreadsheet = new Spreadsheet();
            $this->setWorksheetHeaders();
        }

        return $this->spreadsheet;
    }

    protected function setWorksheetHeaders()
    {
        $worksheet = $this->spreadsheet->getActiveSheet();
        $rowIndex = ++$this->spreadsheetRowIndex;
        foreach ($this->getExpectedHeaders() as $key => $value) {
            $coord = $key.$rowIndex;
            $worksheet->getCell($coord)->setValue($value);
        }
        $worksheet->getCell(self::ERROR_COLUMN.$rowIndex)->setValue('validation_errors');
    }

    public function getExpectedHeaders(): array
    {
        return [
            'A' => 'entry_id',
            'B' => 'compiler',
            'C' => 'district',
            'D' => 'modern_name',
            'E' => 'ancient_name',
            'F' => 'survey_verified_on_field',
            'G' => 'threats_looting',
            'H' => 'threats_bulldozer',
            'I' => 'threats_modern_structures',
            'J' => 'threats_modern_canals',
            'K' => 'threats_natural_dunes',
            'L' => 'remarks',
        ];
    }

    protected function writeCurrentWorksheet(Spreadsheet $spreadsheet)
    {
        $writer = new CsvWriter($spreadsheet);
        $writer->setPreCalculateFormulas(false);

        return $writer->save($this->getValidationCsvFilePath());
    }
}
