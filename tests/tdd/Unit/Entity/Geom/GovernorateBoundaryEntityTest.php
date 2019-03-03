<?php

namespace App\Tests\Unit\Entity\Geom;

use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\GovernorateBoundaryEntity;
use App\Entity\Geom\NationBoundaryEntity;

class GovernorateBoundaryEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
    {
        return [
            ['Id', 12],
            ['Name', 'A name'],
            ['AlternativeName', 'An alternative name'],
            ['Geom', 'A geoJson string'],
            ['Nation', new NationBoundaryEntity()]
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $district = new GovernorateBoundaryEntity();
        $district->{"set$prop"}($value);
        $this->assertEquals($value, $district->{"get$prop"}());
    }

    public function testAddDistrictDoesWork()
    {
        $district = new DistrictBoundaryEntity();
        $governorate = new GovernorateBoundaryEntity();
        $governorate->addDistrict($district);
        $this->assertCount(1, $governorate->getDistricts());
    }
}
