<?php

namespace App\Tests\Unit\Entity\Geom;

use App\Entity\VocChronologyEntity;

class ChronologyEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
    {
        return [
            ['Id', 36],
            ['Code', 'AKK'],
            ['Name', 'Akkadian'],
            ['DateLow', -2300],
            ['DateHigh', -2100],
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $site = new VocChronologyEntity();
        $site->{"set$prop"}($value);
        $this->assertEquals($value, $site->{"get$prop"}());
    }

}
