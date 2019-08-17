<?php

namespace App\Tests\Functional\Repository\Tmp;

use App\Entity\Geom\DistrictBoundaryEntity;
use App\Repository\Geom\DistrictBoundaryRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class DistrictBoundaryRepositoryTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->executeSqlAssetFile('tdd/sql/test/repository/geom_district.sql');
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
        $this->assertTableRowsNum(3, 'admbnd2', 'geom');
    }

    public function testFindByNameMethodWillReturnExpectedEntries()
    {
        /** @var DistrictBoundaryRepository $repo */
        $repo = $this->getEntityManager()->getRepository(DistrictBoundaryEntity::class);
        $district = $repo->find(3);
        $this->assertEquals($district, $repo->findByName('sinjar'));
        $this->assertEquals($district, $repo->findByName('Sinjar', false));
    }

    public function testGetDistrictNamesMethodWillReturnExpectedEntries()
    {
        /** @var DistrictBoundaryRepository $repo */
        $repo = $this->getEntityManager()->getRepository(DistrictBoundaryEntity::class);
        $this->assertEquals([
            [
                'id' => 4,
                'name' => 'Hatra',
                'governorate' => 'Ninewa',
                'nation' => 'Iraq'
            ],
            [
                'id' => 3,
                'name' => 'Sinjar',
                'governorate' => 'Ninewa',
                'nation' => 'Iraq'
            ],
            [
                'id' => 2,
                'name' => 'Tilkaif',
                'governorate' => 'Ninewa',
                'nation' => 'Iraq'
            ],
        ], $repo->getEntries());
    }
}
