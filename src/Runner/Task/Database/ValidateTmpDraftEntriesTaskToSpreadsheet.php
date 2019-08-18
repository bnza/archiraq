<?php

namespace App\Runner\Task\Database;

use App\Entity\Tmp\DraftEntity;
use App\Runner\Task\Spreadsheet\SpreadsheetInteractionTrait;
use Bnza\JobManagerBundle\Event\SummaryEntryEvent;
use Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException;
use Bnza\JobManagerBundle\Summary\Entry\ErrorEntry;

class ValidateTmpDraftEntriesTaskToSpreadsheet extends AbstractValidateTmpDraftEntriesTask
{
    use SpreadsheetInteractionTrait;

    const ERROR_COLUMN = 'AC';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:validate-tmp-draft-to-spreadsheet';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Validating temporary draft entities ("tmp"."draft") to spreadsheet';
    }

    /**
     * Persists constraint validation errors to DB
     * @param DraftEntity $draft
     * @param $errors
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function persistErrors(DraftEntity $draft, $errors)
    {
        $this->draftContainsErrors = true;
        $worksheet = $this->getSpreadsheet()->getActiveSheet();
        //DB row order MUST be coincide with spreadsheet.
        //stepsNum are 0 index
        //First spreadsheet row contains header
        $coord = self::ERROR_COLUMN.($this->getCurrentStepNum()+2);
        $worksheet->getCell($coord)->setValue((string) $errors);
    }

    /**
     * @throws JobManagerNonCriticalErrorException
     */
    public function terminate(): void
    {
        parent::terminate();
        if ($this->draftContainsErrors) {
            $this->writeCurrentWorksheet($this->getSpreadsheet(), self::ERROR_COLUMN);
            $entry = new ErrorEntry($this, 'Draft validation failed');
            $event = new SummaryEntryEvent($entry);
            $this->getJob()->getDispatcher()->dispatch($event);
            throw new JobManagerNonCriticalErrorException($entry->getMessage());
        }
    }
}
