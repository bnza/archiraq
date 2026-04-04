<?php

namespace App\Tests\Functional\Repository\Tmp;

use App\Entity\Voc\ChronologyEntity;
use App\Repository\Voc\ChronologyRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class ChronologyRepositoryTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass(): void
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        //$this->executeSqlAssetFile('tdd/sql/test/repository/voc_chronology.sql');
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }

//    public function assertPreConditions(): void
//    {
//        $this->assertTableRowsNum(4, 'chronology', 'voc');
//    }

    public function codesDataProvider()
    {
        return [
            ['ED2', true],
            ['XXX', false]
        ];
    }

    /**
     * @dataProvider codesDataProvider
     * @param string $code
     * @param bool $expected
     */
    public function testCodeExistsMethodWillReturnExpectedValue(string $code, bool $expected)
    {
        /** @var ChronologyRepository $repo */
        $repo = $this->getEntityManager()->getRepository(ChronologyEntity::class);
        $this->assertEquals($repo->codeExists($code), $expected);
    }
}
