<?php


namespace App\Tests\Unit\Runner\Task;


use App\Tests\Functional\TestWorkDirTrait;
use App\Tests\Unit\MockUtilsTrait;
use App\Runner\Task\GetContributeMetadataFromTextFileTask;
use App\Entity\ContributeEntity;

class GetContributeMetadataFromTextFileTest extends \PHPUnit\Framework\TestCase
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

    public function testGetContributeWillBeLoadedFromSpreadsheet()
    {
        $filename = 'metadata.txt';
        $this->copyAssetToTempDir("tdd/txt/$filename", $filename);
        /**
         * @var GetContributeMetadataFromTextFileTask $task
         */
        $task = $this->getMockTaskWithMockedJob(GetContributeMetadataFromTextFileTask::class);

        $task->setTextMetadataFilePath($this->getTestDir().DIRECTORY_SEPARATOR.$filename);
        $contribute = new ContributeEntity();
        $contribute->setSha1($task->getJob()->getId());
        $contribute->setEmail('example@email.com');
        $contribute->setContributor('J. Smith');
        $contribute->setDescription("Some further remarks on features.\nIn multiline mode");
        $contribute->setInstitution('University of Bologna');
        $this->assertEquals($contribute, $task->getContribute());
    }
}
