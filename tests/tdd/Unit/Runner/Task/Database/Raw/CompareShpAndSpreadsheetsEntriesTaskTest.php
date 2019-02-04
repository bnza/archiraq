<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/02/19
 * Time: 13.13.
 */

namespace App\Tests\Unit\Runner\Task\Database\Raw;

use App\Runner\Task\Database\Raw\CompareShpAndSpreadsheetsEntriesTask;
use App\Tests\Unit\MockUtilsTrait;
use Bnza\JobManagerBundle\Event\SummaryEntryEvent;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CompareShpAndSpreadsheetsEntriesTaskTest extends \PHPUnit\Framework\TestCase
{
    use MockUtilsTrait;

    /**
     * @expectedException \Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException
     * @expectedExceptionMessage Shapefile and Spreadsheet entries does not match
     */
    public function testMethodTerminateWillThrowNonCriticalExcetion()
    {
        $task = $this->getMockTaskWithMockedJob(
            CompareShpAndSpreadsheetsEntriesTask::class,
            ['getSpreadsheetDifference', 'getShapefileDifference']
        );
        $task->method('getSpreadsheetDifference')->willReturn(['TES.001']);
        $task->method('getShapefileDifference')->willReturn(['TES.002']);
        $task->terminate();
    }

    /**
     * @expectedException \Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException
     * @expectedExceptionMessage Shapefile and Spreadsheet entries does not match
     */
    public function testMethodTerminateWillThrowDispatchSummaryEntryEvent()
    {
        $this->getMockDispatcher(EventDispatcher::class, ['dispatch']);
        $this->mockDispatcher->method('dispatch')->with(
            $this->equalTo(SummaryEntryEvent::NAME),
            $this->isInstanceOf(SummaryEntryEvent::class)
        );

        $this->getMockJob(JobInterface::class, ['getDispatcher']);
        $this->mockJob->method('getDispatcher')->willReturn($this->mockDispatcher);
        $task = $this->getMockTaskWithMockedJob(
            CompareShpAndSpreadsheetsEntriesTask::class,
            ['getSpreadsheetDifference', 'getShapefileDifference']
        );

        $task->method('getSpreadsheetDifference')->willReturn(['TES.001']);
        $task->method('getShapefileDifference')->willReturn(['TES.002']);
        $task->terminate();
    }
}
