<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 17.30.
 */

namespace App\Tests\Functional\Entity\Geom;

use App\Entity\Geom\NationBoundaryEntity;
use App\Tests\Functional\AbstractPgTestIsolation;

class NationBoundaryEntityTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
    }

    public function testPersistEntityDoesWork()
    {
        $this->executeSqlAssetFile('tdd/sql/admbnd0.sql');
        $this->executeSqlAssetFile('tdd/sql/admbnd1.sql');
        $this->executeSqlAssetFile('tdd/sql/admbnd2.sql');
        $nation = $this->getEntityManager()->getRepository(NationBoundaryEntity::class)->find('IQ');
        $this->assertCount(18, $nation->getGovernorates());
        $this->assertCount(4, $nation->getGovernorates()->first()->getDistricts());
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }
}
