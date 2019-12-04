<?php

namespace App\Tests\Functional\Command\Job;

use App\Command\Job\FullImportPublishedSitesZipShapefileJobCommand as SutCommand;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\TestWorkDirTrait;
use App\Tests\Functional\Command\CommandUtilsTrait;
use Symfony\Component\Console\Command\Command;

class FullImportPublishedSitesZipShapefileJobCommandTest extends AbstractPgTestIsolation
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
        $this->executeSqlAssetFile('tdd/sql/admbnd0.sql');
        $this->executeSqlAssetFile('tdd/sql/admbnd1.sql');
        $this->executeSqlAssetFile('tdd/sql/admbnd2.sql');
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $this->setUpAssets('tdd/shp/zip/published_full_import_job/working.shp.zip');
        $tester = $this->executeCommandTester(SutCommand::getDefaultName(), ['path' => $this->zipPath]);
        $this->assertEquals(0, $tester->getStatusCode());
    }

    public function setCommandParameters(Command $command)
    {
        $command->setEntityManager($this->getEntityManager());
        $command->setValidator($this->getValidator());
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
