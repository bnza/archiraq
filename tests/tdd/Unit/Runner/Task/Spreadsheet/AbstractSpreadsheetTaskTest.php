<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 30/01/19
 * Time: 20.39.
 */

namespace App\Tests\Unit\Runner\Task\Spreadsheet;

use App\Runner\Task\Spreadsheet\AbstractSpreadsheetTask;
use App\Tests\Functional\TestWorkDirTrait;
use App\Tests\Unit\MockUtilsTrait;

class AbstractSpreadsheetTaskTest extends \PHPUnit\Framework\TestCase
{
    use MockUtilsTrait;
    use TestWorkDirTrait;

    public function setUp()
    {
        $this->setUpBaseWorkDir();
    }

    public function tearDown()
    {
        $this->tearDownDir($this->getTestDir());
    }

    /**
     * @testWith        ["ods"]
     *                  ["xlsx"]
     *                  ["xls"]
     *                  ["csv"]
     *
     * @param string $type
     */
    public function testMethodGetHeadersWillReturnHeaders(string $type)
    {
        $filename = "headers.$type";
        $this->copyAssetToTempDir("tdd/spreadsheet/headers/$filename", $filename);
        /**
         * @var AbstractSpreadsheetTask
         */
        $task = $this->getMockTask(AbstractSpreadsheetTask::class);
        $task->setSpreadSheetPath($this->getTestDir().DIRECTORY_SEPARATOR.$filename);
        $expected = [
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
        $this->assertEquals($expected, $task->getHeaders());
    }

    /**
     * @expectedException \App\Exception\Import\SpreadsheetHeadersMismatchException
     * @expectedExceptionMessage Spreadsheet headers does not match the expected ones in class
     */
    public function testMethodCheckHeadersWithHeadersMismatchWillThrowException()
    {
        /**
         * @var AbstractSpreadsheetTask
         */
        $task = $this->getMockTask(
            AbstractSpreadsheetTask::class,
            [
                'getHeaders',
                'getExpectedHeaders',
                'createTempTable',
            ]
        );

        $headers = ['A' => 'id', 'B' => 'date'];
        $expectedHeaders = ['A' => 'id', 'B' => 'year'];

        $task->method('getHeaders')->willReturn($headers);
        $task->method('getExpectedHeaders')->willReturn($expectedHeaders);

        $method = $this->getNonPublicMethod(AbstractSpreadsheetTask::class, 'checkHeaders');
        $method->invoke($task);
    }
}
