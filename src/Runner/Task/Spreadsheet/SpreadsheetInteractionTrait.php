<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 01/02/19
 * Time: 11.51.
 */

namespace App\Runner\Task\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Document\Properties;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column\Rule;

trait SpreadsheetInteractionTrait
{
    /**
     * @var Spreadsheet
     */
    private $spreadsheet;

    /**
     * @var string
     */
    protected $spreadsheetPath = '';

    /**
     * @return string
     */
    public function getSpreadsheetPath(): string
    {
        return $this->spreadsheetPath;
    }

    /**
     * @param string $spreadsheetPath
     */
    public function setSpreadsheetPath(string $spreadsheetPath): void
    {
        $this->spreadsheetPath = $spreadsheetPath;
    }

    public function getSpreadsheet(): Spreadsheet
    {
        if (!$this->spreadsheet) {
            $this->spreadsheet = $this->loadSpreadSheet();
        }
        return $this->spreadsheet;
    }

    protected function loadSpreadSheet(): Spreadsheet
    {
        $inputFileType = IOFactory::identify($this->getSpreadsheetPath());
        $reader = IOFactory::createReader($inputFileType);

        return $reader->load($this->getSpreadsheetPath());
    }

    protected function readCurrentWorksheet(IReadFilter $filter = null, bool $ro = true): Worksheet
    {
        $inputFileType = IOFactory::identify($this->getSpreadsheetPath());
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly($ro);
        if ($filter) {
            $reader->setReadFilter($filter);
        }
        $spreadsheet = $reader->load($this->getSpreadsheetPath());

        return $spreadsheet->getActiveSheet();
    }

    protected function getSpreadsheetProperties(): Properties
    {
        $spreadsheet = $this->loadSpreadSheet();

        return $spreadsheet->getProperties();
    }

    protected function writeCurrentWorksheet(Spreadsheet $spreadsheet, string $errorColumn)
    {
        $highestRow = $this->spreadsheet->getActiveSheet()->getHighestDataRow();
        //$dims = $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:'.$errorColumn.$highestRow);
        $autoFilter = $spreadsheet->getActiveSheet()->getAutoFilter();
        $columnFilter = $autoFilter->getColumn($errorColumn);
        $columnFilter->setFilterType(Column::AUTOFILTER_FILTERTYPE_FILTER);
        $columnFilter->createRule()
            ->setRule(
                Rule::AUTOFILTER_COLUMN_RULE_NOTEQUAL,
                ''
            );
        $writer = IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->setPreCalculateFormulas(false);
        return $writer->save(dirname($this->getSpreadsheetPath()).DIRECTORY_SEPARATOR.'validationErrors.csv');
    }
}
