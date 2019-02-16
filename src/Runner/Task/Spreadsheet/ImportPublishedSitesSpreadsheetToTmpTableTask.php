<?php

namespace App\Runner\Task\Spreadsheet;

use App\Runner\Task\TaskEntityManagerTrait;
use Doctrine\DBAL\Driver\Statement;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPublishedSitesSpreadsheetToTmpTableTask extends AbstractSpreadsheetTask
{
    use TaskEntityManagerTrait;

    /**
     * @var Statement
     */
    protected $insertStmt;

    protected $dateStyle;

    public function getName(): string
    {
        return 'app:task:spreadsheet:import-published-sites-tmp-table';
    }

    public function getDefaultDescription(): string
    {
        return 'Importing shapefile into db using shp2pgsql command';
    }

    public function getExpectedHeaders(): array
    {
        return [
            'A' => 'entry_id',
            'B' => 'archiraq_id',
            'C' => 'modern_name',
            'D' => 'ancient_name',
            'E' => 'district',
            'F' => 'nearest_city',
            'G' => 'cadastre',
            'H' => 'sbah_no',
            'I' => 'survey_visit_date',
            'J' => 'survey_verified_on_field',
            'K' => 'survey_type',
            'L' => 'survey_prev_refs',
            'M' => 'features_epigraphic',
            'N' => 'features_ancient_structures',
            'O' => 'features_paleochannels',
            'P' => 'features_remarks',
            'Q' => 'site_chronology',
            'R' => 'excavations_whom_when',
            'S' => 'excavations_bibliography',
            'T' => 'threats_natural_dunes',
            'U' => 'threats_looting',
            'V' => 'threats_cultivation_trenches',
            'W' => 'threats_modern_structures',
            'X' => 'threats_modern_canals',
            'Y' => 'remarks',
            'Z' => 'compiler',
            'AA' => 'compilation_date',
            'AB' => 'credits',
        ];
    }

    protected function insertValues(Worksheet $worksheet, int $rowIndex)
    {
        $values = [];
        $headers = $this->getHeaders();
        if ($rowIndex > 1) {
            foreach ($headers as $column => $key) {
                $cell = $worksheet->getCell("$column$rowIndex");
                $value = $cell->getValue();
                if ('archiraq_id' !== $key) {
                    if ($value && 'compilation_date' === $key) {
                        $date = Date::excelToDateTimeObject($value)->format('Y-m-d');
                        $values[$key] = $date;
                    }
                    $values[$key] = $value ?: null;
                }
            }
            $values['contribute_id'] = null;
            $values['geom'] = null;
            $values['id'] = $rowIndex;
            $this->getInsertPreparedStatement()->execute($values);
        }
    }

    protected function executeStep(array $arguments): void
    {
        $this->insertValues(...$arguments);
    }

    protected function getInsertPreparedStatement(): Statement
    {
        if (!$this->insertStmt) {
            $this->insertStmt = $this->prepareInsertStatement();
        }

        return $this->insertStmt;
    }

    protected function prepareInsertStatement(): Statement
    {
        $id = $this->getJob()->getId();

        $sql = <<<EOT
INSERT INTO "draft$id"
   ("id","contribute_id", "entry_id", "modern_name", "ancient_name", "district", "nearest_city", "cadastre", "sbah_no", "survey_visit_date", "survey_verified_on_field", "survey_type", "survey_prev_refs", "features_epigraphic", "features_ancient_structures", "features_paleochannels", "features_remarks", "site_chronology", "excavations_whom_when", "excavations_bibliography", "threats_natural_dunes", "threats_looting", "threats_cultivation_trenches", "threats_modern_structures", "threats_modern_canals", "remarks", "compiler", "compilation_date", "credits", "geom")
	VALUES (:id, :contribute_id, :entry_id, :modern_name, :ancient_name, :district, :nearest_city, :cadastre, :sbah_no, :survey_visit_date, :survey_verified_on_field, :survey_type, :survey_prev_refs, :features_epigraphic, :features_ancient_structures, :features_paleochannels, :features_remarks, :site_chronology, :excavations_whom_when, :excavations_bibliography, :threats_natural_dunes, :threats_looting, :threats_cultivation_trenches, :threats_modern_structures, :threats_modern_canals, :remarks, :compiler, TO_DATE(:compilation_date, 'YYYY-MM-DD'), :credits, :geom);
EOT;

        return $this->getEntityManager()->getConnection()->prepare($sql);
    }

    protected function createTempTable()
    {
        $id = $this->getJob()->getId();
        $sql = <<<EOT
CREATE TEMPORARY TABLE "draft$id" AS SELECT * FROM "tmp"."draft" LIMIT 0; 
EOT;

        $this->getEntityManager()->getConnection()->exec($sql);
    }

    protected function configure(): void
    {
        $this->checkHeaders();
        $this->createTempTable();
        //$this->dateStyle = $this->getDateStyle();
    }

    public function getSteps(): iterable
    {
        return $this->getRowGenerator();
    }
}
