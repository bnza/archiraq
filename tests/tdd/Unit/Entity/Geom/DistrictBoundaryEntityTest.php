<?php

namespace App\Tests\Unit\Entity\Geom;

use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\GovernorateBoundaryEntity;

class DistrictBoundaryEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
    {
        return [
            ['Id', 12],
            ['Name', 'A name'],
            ['AlternativeName', 'An alternative name'],
            ['Geom', 'A geoJson string'],
            ['Governorate', new GovernorateBoundaryEntity()]
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $district = new DistrictBoundaryEntity();
        $district->{"set$prop"}($value);
        $this->assertEquals($value, $district->{"get$prop"}());
    }
}
