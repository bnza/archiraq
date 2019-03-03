<?php

namespace App\Tests\Functional\Command\Job;

use App\Command\Job\ValidateTmpDraftEntriesCommand as SutCommand;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Command\CommandUtilsTrait;
use Symfony\Component\Console\Command\Command;

class ValidateTmpDraftEntriesCommandTest extends AbstractPgTestIsolation
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
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_job/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_job/invalid_fixtures.sql');
        $tester = $this->executeCommandTester(SutCommand::getDefaultName(), ['contribute' => 100]);
        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertTableRowsNum(2, 'draft_error', 'tmp');
    }

    public function setCommandParameters(Command $command)
    {
        $command->setEntityManager($this->getEntityManager());
        $command->setValidator($this->getValidator());
    }
}
