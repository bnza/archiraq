<?php

namespace App\Tests\Functional\Runner\Task\Database;

use App\Entity\ContributeEntity;
use App\Runner\Task\Database\ValidateTmpDraftEntriesTaskToDb;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;
use PHPUnit\Framework\MockObject\MockObject;

class ValidateTmpDraftEntriesTaskToDbTest extends AbstractPgTestIsolation
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

    public function testMethodValidateSiteWillNotCallMethodPersistErrorsWhenNoErrors()
    {
        $this->assertTableRowsNum(0, 'contribute');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/valid_fixtures.sql');
        $this->assertTableRowsNum(1, 'contribute');
        $this->assertTableRowsNum(1, 'draft', 'tmp');
        $this->setUpTask([], ['persistErrors', 'validateDraft']);
        $this->getTask()->expects($this->once())->method('validateDraft');
        $this->getTask()->expects($this->never())->method('persistErrors');
        $this->getTask()->run();
    }

    public function testMethodValidateSiteWillCallMethodPersistErrorsWhenErrors()
    {
        $this->assertTableRowsNum(0, 'contribute');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/invalid_fixtures.sql');
        $this->assertTableRowsNum(1, 'contribute');
        $this->assertTableRowsNum(1, 'draft', 'tmp');
        $this->assertTableRowsNum(0, 'draft_error', 'tmp');
        $this->setUpTask([], ['validateDraft']);
        $this->getTask()->expects($this->once())->method('validateDraft');
        $this->getTask()->run();
        $this->assertTableRowsNum(2, 'draft_error', 'tmp');
    }

    public function testMethodValidateDraftWillValidateChronologyCodes()
    {
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/valid_chronology_fixtures.sql');
        $this->setUpTask([], ['persistErrors', 'validateSite']);
        $this->getTask()->expects($this->once())->method('validateSite');
        $this->getTask()->expects($this->never())->method('persistErrors');
        $this->getTask()->run();
    }

    public function testMethodValidateDraftWillCallMethodPersistErrorsWhenChronologyCodesErrors()
    {
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/invalid_chronology_fixtures.sql');
        $this->setUpTask([], ['validateSite']);
        $this->getTask()->expects($this->once())->method('validateSite');
        $this->getTask()->run();
        $this->assertTableRowsNum(2, 'draft_error', 'tmp');
    }

    public function testMethodValidateDraftWillValidateDistrict()
    {
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/valid_district_fixtures.sql');
        $this->setUpTask([], ['persistErrors', 'validateSite']);
        $this->getTask()->expects($this->once())->method('validateSite');
        $this->getTask()->expects($this->never())->method('persistErrors');
        $this->getTask()->run();
    }

    public function testMethodValidateDraftWillCallMethodPersistErrorsWhenDistrictErrors()
    {
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/invalid_district_fixtures.sql');
        $this->setUpTask([], ['validateSite']);
        $this->getTask()->expects($this->once())->method('validateSite');
        $this->getTask()->run();
        $this->assertTableRowsNum(1, 'draft_error', 'tmp');
    }

    public function testMethodValidateDraftWillCallMethodPersistErrorsWhenGeometryTypeErrors()
    {
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/invalid_geometry_type_fixtures.sql');
        $this->setUpTask([], ['validateSite']);
        $this->getTask()->expects($this->once())->method('validateSite');
        $this->getTask()->run();
        $this->assertTableRowsNum(1, 'draft_error', 'tmp');
    }

    public function testMethodValidateDraftWillCallMethodPersistErrorsWhenGeometrySridErrors()
    {
        $this->executeSqlAssetFile('tdd/sql/test/validate_tmp_drafts_task/invalid_geometry_srid_fixtures.sql');
        $this->setUpTask([], ['validateSite']);
        $this->getTask()->expects($this->once())->method('validateSite');
        $this->getTask()->run();
        $this->assertTableRowsNum(1, 'draft_error', 'tmp');
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
        return ValidateTmpDraftEntriesTaskToDb::class;
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
    }
}
