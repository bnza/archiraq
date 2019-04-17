<?php

namespace App\Tests\Functional\Runner\Task\Database;

use App\Entity\ContributeEntity;
use App\Runner\Task\Database\ValidateTmpDraftEntriesTaskToCsv;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;
use PHPUnit\Framework\MockObject\MockObject;
use Bnza\JobManagerBundle\Exception\JobManagerNonCriticalErrorException;

class ValidateTmpDraftEntriesTaskToCsvTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    /**
     * @var ContributeEntity
     */
    private $contribute;

    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->setUpBaseWorkDir();
        $this->setUpBaseOmDir();
    }

    public function tearDown()
    {
        $this->tearDownDir($this->getTestDir());
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function testMethodValidateSiteWillCallMethodPersistErrorsOnCsvFileWhenErrors()
    {
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/invalid_fixtures.sql');
        $this->setUpTask([], ['validateDraft']);
        $this->getTask()->expects($this->once())->method('validateDraft');
        $this->setUpWorkDir($this->getTask()->getJob()->getId());
        try {
            $this->getTask()->run();
        } catch (JobManagerNonCriticalErrorException $e) {
            $this->assertFileExists($this->getTask()->getValidationCsvFilePath());
        }
    }

    /**
     * @return MockObject|ValidateTmpDraftEntriesTaskToDbTest
     */
    protected function getTask()
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return ValidateTmpDraftEntriesTaskToCsv::class;
    }

    protected function setUpAssets()
    {
    }

    protected function callTaskSetters()
    {
        $this->contribute = $this
            ->getEntityManager()
            ->getRepository(ContributeEntity::class)
            ->find(1);
        $this->getTask()->setEntityManager($this->getEntityManager());
        $this->getTask()->setContribute($this->contribute);
        $this->getTask()->setValidator($this->getValidator());
        $this->getTask()->setValidationCsvFilePath($this->getWorkDir($this->getTask()->getJob()->getId()).DIRECTORY_SEPARATOR.'fake.shp.zip');
    }
}
