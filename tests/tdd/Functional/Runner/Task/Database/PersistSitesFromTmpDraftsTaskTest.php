<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 05/02/19
 * Time: 17.12.
 */

namespace App\Tests\Functional\Runner\Task\Database;

use App\Entity\ContributeEntity;
use App\Runner\Task\Database\PersistSitesFromTmpDraftsTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;

class PersistSitesFromTmpDraftsTaskTest extends AbstractPgTestIsolation
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

    public function assertPreConditions()
    {
        $this->assertTableRowsNum(0, 'site');
    }

    public function testMethodRunWillPersistSiteEntity()
    {
        $this->executeSqlAssetFile('tdd/sql/test/persist_tmp_drafts_task/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/persist_tmp_drafts_task/fixtures.sql');
        $this->contribute = $this->getEntityManager()->getRepository(ContributeEntity::class)->find(1);
        $this->runTask();
        $this->assertTableRowsNum(1, 'site');
    }

    /**
     * @return MockObject|PersistSitesFromTmpDraftsTask
     */
    protected function getTask(): PersistSitesFromTmpDraftsTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return PersistSitesFromTmpDraftsTask::class;
    }

    protected function setUpAssets()
    {
    }

    protected function callTaskSetters()
    {
        $this->getTask()->setEntityManager($this->getEntityManager());
        $this->getTask()->setContribute($this->contribute);
    }
}
