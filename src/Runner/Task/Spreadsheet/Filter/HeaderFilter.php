<?php

namespace App\Runner\Task\Spreadsheet\Filter;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class HeaderFilter implements IReadFilter
{
    public function readCell($column, $row, $worksheetName = '')
    {
        return 1 === $row;
    }
}
