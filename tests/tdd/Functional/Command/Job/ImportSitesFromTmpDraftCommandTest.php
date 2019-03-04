<?php

namespace App\Tests\Functional\Command\Job;

use App\Command\Job\ImportSitesFromTmpDraftCommand as SutCommand;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Command\CommandUtilsTrait;
use Symfony\Component\Console\Command\Command;

class ImportSitesFromTmpDraftCommandTest extends AbstractPgTestIsolation
{
    use CommandUtilsTrait;

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
    }

    public function testSuccessfulCommand()
    {
        $this->assertTableRowsNum(0, 'site');
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $this->executeSqlAssetFile('tdd/sql/test/import_sites_from_tmp_draft_job/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/import_sites_from_tmp_draft_job/valid_fixtures_not_validated.sql');
        $tester = $this->executeCommandTester(SutCommand::getDefaultName(), ['contribute' => 101]);
        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertTableRowsNum(1, 'site');
    }

    public function setCommandParameters(Command $command)
    {
        $command->setEntityManager($this->getEntityManager());
        $command->setValidator($this->getValidator());
    }
}
