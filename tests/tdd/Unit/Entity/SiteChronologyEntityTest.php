<?php

namespace App\Tests\Unit\Entity;


use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\Voc\ChronologyEntity;

class SiteChronologyEntityTest extends \PHPUnit\Framework\TestCase
{
    public function propValueProvider(): array
    {
        return [
            ['Id', 36],
            ['Site', new SiteEntity()],
            ['Chronology', new ChronologyEntity()]
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $site = new SiteChronologyEntity();
        $site->{"set$prop"}($value);
        $this->assertEquals($value, $site->{"get$prop"}());
    }
}
