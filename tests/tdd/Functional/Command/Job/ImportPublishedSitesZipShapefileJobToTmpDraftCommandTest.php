<?php

namespace App\Tests\Functional\Command\Job;

use App\Command\Job\ImportPublishedSitesZipShapefileJobToTmpDraftCommand as SutCommand;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\TestWorkDirTrait;
use App\Tests\Functional\Command\CommandUtilsTrait;
use Symfony\Component\Console\Command\Command;

class ImportPublishedSitesZipShapefileJobToTmpDraftCommandTest extends AbstractPgTestIsolation
{
    use TestWorkDirTrait;
    use CommandUtilsTrait;

    /**
     * @var string
     */
    protected $zipPath = '';

    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
        $this->getFilesystem()->remove($this->command->getWorkDir());
    }

    public function assertPreConditions()
    {
        $this->assertTableRowsNum(0, 'draft', 'tmp');
    }

    public function assertPostConditions()
    {
        $this->assertFileExists($this->command->getWorkDir().DIRECTORY_SEPARATOR.'summary.json');
    }

    public function testSuccessfulCommand()
    {
        $this->setUpAssets('tdd/shp/zip/site.shp.zip');
        $tester = $this->executeCommandTester(SutCommand::getDefaultName(), ['path' => $this->zipPath]);
        $this->assertEquals(0, $tester->getStatusCode());
    }

    /**
     * @expectedException \Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException
     * Shapefile and Spreadsheet entries does not match
     */
    public function testEntryMismatchCommand()
    {
        $this->setUpAssets('tdd/shp/zip/entryMismatch.shp.zip');
        $tester = $this->executeCommandTester(SutCommand::getDefaultName(), ['path' => $this->zipPath]);
    }

    public function setCommandParameters(Command $command)
    {
        $command->setEntityManager($this->getEntityManager());
    }

    /**
     * @param string $zipPath The zipPath relative to tests/assets dir
     */
    protected function setUpAssets(string $zipPath)
    {
        $this->zipPath = $this->copyAssetToTempDir($zipPath, 'site.zip');
        $this->assertFileExists($this->zipPath);
    }
}
