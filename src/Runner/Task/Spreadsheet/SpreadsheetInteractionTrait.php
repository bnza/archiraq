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

trait SpreadsheetInteractionTrait
{
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
}
