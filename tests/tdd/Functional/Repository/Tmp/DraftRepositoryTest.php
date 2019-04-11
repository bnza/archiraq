<?php


namespace App\Tests\Functional\Repository\Tmp;


use App\Entity\Tmp\DraftEntity;
use App\Repository\Tmp\DraftRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class DraftRepositoryTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->executeSqlAssetFile('tdd/sql/test/repository/tmp_draft.sql');
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function assertPreConditions()
    {
        $this->assertTableRowsNum(3, 'draft', 'tmp');
    }

    public function testMethodGetByContributeMethodWillReturnExpectedEntries()
    {
        /** @var DraftRepository $repo */
        $repo = $this->getEntityManager()->getRepository(DraftEntity::class);
        $this->assertCount(2, $repo->getByContribute(100));
    }

    public function testMethodCountByContributeMethodWillReturnExpectedEntries()
    {
        /** @var DraftRepository $repo */
        $repo = $this->getEntityManager()->getRepository(DraftEntity::class);
        $this->assertEquals(2, $repo->countByContribute(100));
    }
}
