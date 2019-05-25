<?php

namespace App\Tests\Functional\Repository\Tmp;

use App\Entity\Voc\ChronologyEntity;
use App\Repository\Voc\ChronologyRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class ChronologyRepositoryTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->executeSqlAssetFile('tdd/sql/test/repository/voc_chronology.sql');
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
        $this->assertTableRowsNum(4, 'chronology', 'voc');
    }

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

    public function testGetDistrictNamesMethodWillReturnExpectedEntries()
    {
        /** @var ChronologyRepository $repo */
        $repo = $this->getEntityManager()->getRepository(ChronologyEntity::class);
        $this->assertEquals(
            [
                [
                    'id' => 17,
                    'name' => 'EARLY DYNASTIC',
                    'code' => 'EDA',
                    'date_low' => -2900,
                    'date_high' => -2350,
                ],
                [
                    'id' => 12,
                    'name' => 'EARLY DYNASTIC I',
                    'code' => 'ED1',
                    'date_low' => -2900,
                    'date_high' => -2700,
                ],
                [
                    'id' => 11,
                    'name' => 'EARLY DYNASTIC II',
                    'code' => 'ED2',
                    'date_low' => -2700,
                    'date_high' => -2600,
                ],
                [
                    'id' => 14,
                    'name' => 'EARLY DYNASTIC III',
                    'code' => 'ED3',
                    'date_low' => -2600,
                    'date_high' => -2350,
                ],
            ],
            $repo->getEntries()
        );
    }
}
