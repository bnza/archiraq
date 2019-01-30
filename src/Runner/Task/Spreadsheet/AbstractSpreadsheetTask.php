<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 30/01/19
 * Time: 19.40
 */

namespace App\Runner\Task\Spreadsheet;

use App\Exception\Import\SpreadsheetHeadersMismatchException;
use App\Runner\Task\Spreadsheet\Filter\HeaderFilter;
use App\Runner\Task\Spreadsheet\Filter\DataFilter;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class AbstractSpreadsheetTask extends AbstractTask
{
    use SpreadsheetInteractionTrait;
    /**
     * @var array
     */
    protected $headers = [];

    abstract public function getExpectedHeaders(): array;

    /**
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getHeaders(): array
    {
        if (!$this->headers) {
            $this->headers = $this->extractHeadersFromFile();
        }
        return $this->headers;
    }

    /**
     * Extract Spreadsheet header from file as an associative array "column" => "value"
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function extractHeadersFromFile()
    {
        $filter = new HeaderFilter();
        $worksheet = $this->readCurrentWorksheet($filter);
        $headers = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cell) {
                if ($value = $cell->getValue()) {
                    $headers[$cell->getColumn()] = $value;
                }
            }
            break;
        }
        return $headers;
    }

    protected function getRowGenerator(): \Generator
    {
        $filter = new DataFilter();
        $worksheet = $this->readCurrentWorksheet($filter);
        $generator = function () use ($worksheet) {
            foreach ($worksheet->getRowIterator() as $row) {
                if ($row->getRowIndex() === 1) {
                    continue;
                }
                if (!$worksheet->getCell("A{$row->getRowIndex()}")->getValue()) {
                    break;
                }
                yield [$worksheet, $row->getRowIndex()];
            }
        };
        return $generator();
    }

    protected function checkHeaders(bool $throw = true): bool
    {
        $expected = \array_values($this->getHeaders());
        $actual = \array_values($this->getExpectedHeaders());
        \sort($expected);
        \sort($actual);
        $equals = $actual === $expected;
        if (!$equals && $throw) {
            throw new SpreadsheetHeadersMismatchException($expected, $actual, self::class);
        }
        return $equals;
    }
}
