<?php

namespace App\Tests\Unit\Entity\Geom;

use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteEntity;

class SiteBoundaryEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
    {
        return [
            ['Geom', 'A geoJson string'],
            ['Site', new SiteEntity()]
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $site = new SiteBoundaryEntity();
        $site->{"set$prop"}($value);
        $this->assertEquals($value, $site->{"get$prop"}());
    }

    public function testMethodGetIdDoesWork()
    {
        $site = new SiteEntity();
        $site->setId(100);
        $siteBoundary = new SiteBoundaryEntity();
        $siteBoundary->setSite($site);
        $this->assertEquals(100, $siteBoundary->getId());
    }
}
