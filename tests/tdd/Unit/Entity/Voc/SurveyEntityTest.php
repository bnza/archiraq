<?php

namespace App\Tests\Unit\Entity\Geom;

use App\Entity\Voc\SurveyEntity;

class SurveyEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
    {
        return [
            ['Id', 36],
            ['Code', 'ADAMS1972'],
            ['Name', 'Some researches on Iraq'],
            ['Remarks', 'Some remarks on survey'],
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $site = new SurveyEntity();
        $site->{"set$prop"}($value);
        $this->assertEquals($value, $site->{"get$prop"}());
    }

}
