<?php

namespace App\Tests\Unit\Exception;


use App\Exception\Import\SpreadsheetHeadersMismatchException;

class SpreadsheetHeadersMismatchExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $e = new SpreadsheetHeadersMismatchException(['a','b'], ['c'],self::class);
        $this->assertEquals('Spreadsheet headers does not match the expected ones in class "App\Tests\Unit\Exception\SpreadsheetHeadersMismatchExceptionTest"', $e->getMessage());
        $this->assertEquals(['a','b'], $e->getExpected());
        $this->assertEquals(['c'], $e->getActual());
    }
}
