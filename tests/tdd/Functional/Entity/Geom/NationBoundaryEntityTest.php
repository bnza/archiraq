<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 17.30.
 */

namespace App\Tests\Functional\Entity\Geom;

use App\Entity\Geom\GovernorateBoundaryEntity;
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

    public function propValueProvider(): array
    {
        return [
            ['Code', 'IQ'],
            ['Name', 'A name'],
            ['AlternativeName', 'An alternative name'],
            ['Geom', 'A geoJson string']
        ];
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

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $nation = new NationBoundaryEntity();
        $nation->{"set$prop"}($value);
        $this->assertEquals($value, $nation->{"get$prop"}());
    }

    public function testAddGovernateDoesWork()
    {
        $nation = new NationBoundaryEntity();
        $governorate = new GovernorateBoundaryEntity();
        $nation->addGovernorate($governorate);
        $this->assertCount(1, $nation->getGovernorates());
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
