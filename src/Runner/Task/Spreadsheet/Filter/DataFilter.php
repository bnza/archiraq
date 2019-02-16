<?php

namespace App\Runner\Task\Spreadsheet\Filter;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class DataFilter implements IReadFilter
{
    public function readCell($column, $row, $worksheetName = '')
    {
        return $row > 1;
    }
}
