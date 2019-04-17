<?php

namespace App\Tests\Unit\Runner\Task\Spreadsheet;

use App\Entity\ContributeEntity;
use App\Runner\Task\Spreadsheet\GetContributeFromSpreadsheetMetadataTask;
use App\Tests\Functional\TestWorkDirTrait;
use App\Tests\Unit\MockUtilsTrait;
use PhpOffice\PhpSpreadsheet\Document\Properties;

class GetContributeFromSpreadsheetMetadataTaskTest extends \PHPUnit\Framework\TestCase
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
     * @dataProvider getContributeDataProvider
     *
     * @param string           $description
     * @param ContributeEntity $expected
     */
    public function testGetContributeWillReturnExpectedValue(string $description, ContributeEntity $expected)
    {
        /**
         * @var GetContributeFromSpreadsheetMetadataTask
         */
        $task = $this->getMockTaskWithMockedJob(GetContributeFromSpreadsheetMetadataTask::class, ['getSpreadsheetProperties']);
        $props = new Properties();
        $props->setDescription($description);
        $task->method('getSpreadsheetProperties')->willReturn($props);
        $this->assertEquals($task->getJob()->getId(), $task->getContribute()->getSha1());
        $task->getContribute()->setSha1('');
        $this->assertEquals($expected, $task->getContribute());
    }

    public function testGetContributeWillBeLoadedFromSpreadsheet()
    {
        $filename = 'metadata.xlsx';
        $this->copyAssetToTempDir("tdd/spreadsheet/$filename", $filename);
        /**
         * @var GetContributeFromSpreadsheetMetadataTask
         */
        $task = $this->getMockTaskWithMockedJob(GetContributeFromSpreadsheetMetadataTask::class);

        $task->setSpreadsheetPath($this->getTestDir().DIRECTORY_SEPARATOR.$filename);
        $contribute = new ContributeEntity();
        $contribute->setSha1($task->getJob()->getId());
        $contribute->setEmail('example@email.com');
        $contribute->setContributor('J. Smith');
        $contribute->setDescription("Some further remarks on features.\nIn multiline mode");
        $contribute->setInstitution('University of Bologna');
        $this->assertEquals($contribute, $task->getContribute());
    }

    public function getContributeDataProvider(): array
    {
        $d1 = <<<EOT
contributor: J. Smith
email: example@email.com
institution: University of Bologna

Some further remarks on features.
In multiline mode
EOT;
        $e1 = new ContributeEntity();
        $e1->setContributor('J. Smith');
        $e1->setEmail('example@email.com');
        $e1->setInstitution('University of Bologna');
        $e1->setDescription("Some further remarks on features.\nIn multiline mode");

        return [
          [$d1, $e1],
        ];
    }
}
