<?php

namespace App\Runner\Task\Database\Raw;

use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Bnza\JobManagerBundle\Summary\Entry\ErrorEntry;
use Bnza\JobManagerBundle\Event\SummaryEntryEvent;

/**
 * Compares "id" field values in "tmp"."shp2pgsql[job_id]" and "entry" field values "draft[job_id]" in order to
 * find id field's mismatch. Such tables will be joined and join key fields MUST match.
 *
 * Class CompareShpAndSpreadsheetsEntriesTask
 */
class CompareShpAndSpreadsheetsEntriesTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    private $shapefileDiff;

    private $spreadsheetDiff;

    public function getName(): string
    {
        return 'app:task:db:raw:compare-shp-spreadsheet-entries';
    }

    public function getDefaultDescription(): string
    {
        return 'Comparing shapefile and spreadsheet entries';
    }

    protected function executeStep(array $arguments): void
    {
        $method = $arguments[0];
        $this->$method();
    }

    public function getSteps(): iterable
    {
        return [
            ['getShapefileDifference'],
            ['getSpreadsheetDifference'],
        ];
    }

    /**
     * Returns an array consisting in all the "id" values in "tmp"."shp2pgsql[job_id]" table temporary table BUT NOT
     * in "entry_id" values in "draft[job_id]".
     *
     * @return array
     */
    public function getShapefileDifference(): array
    {
        if (\is_null($this->shapefileDiff)) {
            $id = $this->getJob()->getId();
            $draft = "draft$id";
            $shp = "shp2pgsql$id";
            $sql = <<<EOT
SELECT id FROM "tmp"."$shp" EXCEPT SELECT entry_id FROM "$draft";
EOT;
            $diff = [];
            foreach ($this->getEntityManager()->getConnection()->fetchAll($sql) as $row) {
                $diff[] = $row['id'];
            }
            $this->shapefileDiff = $diff;
        }

        return $this->shapefileDiff;
    }

    /**
     * Returns an array consisting in all the "entry_id" values in "draft[job_id]" temporary table BUT NOT
     * in "id" values in "tmp"."shp2pgsql[job_id]" table.
     *
     * @return array
     */
    public function getSpreadsheetDifference(): array
    {
        if (\is_null($this->spreadsheetDiff)) {
            $id = $this->getJob()->getId();
            $draft = "draft$id";
            $shp = "shp2pgsql$id";
            $sql = <<<EOT
SELECT entry_id FROM "$draft" EXCEPT SELECT id FROM "tmp"."$shp";
EOT;
            $diff = [];
            foreach ($this->getEntityManager()->getConnection()->fetchAll($sql) as $row) {
                $diff[] = $row['entry_id'];
            }

            $this->spreadsheetDiff = $diff;
        }

        return $this->spreadsheetDiff;
    }

    /**
     * @throws JobManagerNonCriticalErrorException
     */
    public function terminate(): void
    {
        $diffs = [];
        if ($spreadsheetDiff = $this->getSpreadsheetDifference()) {
            $diffs['spreadsheet'] = $spreadsheetDiff;
        }
        if ($shpDiff = $this->getShapefileDifference()) {
            $diffs['shapefile'] = $shpDiff;
        }
        if ($diffs) {
            $this->getJob()->pushError('entry_mismatch', $diffs);
            $entry = new ErrorEntry($this, 'Shapefile and Spreadsheet entries does not match', $diffs);
            $event = new SummaryEntryEvent($entry);
            $this->getJob()->getDispatcher()->dispatch($event, SummaryEntryEvent::NAME);
            throw new JobManagerNonCriticalErrorException($entry->getMessage());
        }
    }

    public function isDraftValid(): bool
    {
        return !((bool) $this->shapefileDiff || (bool) $this->spreadsheetDiff);
    }
}
