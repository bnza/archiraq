<?php

namespace App\Tests\Unit\Entity;


use App\Entity\SiteEntity;
use App\Entity\SiteSurveyEntity;
use App\Entity\Voc\SurveyEntity;

class SiteSurveyEntityTest extends \PHPUnit\Framework\TestCase
{
    public function propValueProvider(): array
    {
        return [
            ['Id', 36],
            ['Site', new SiteEntity()],
            ['Survey', new SurveyEntity()],
            ['Ref', 'a'],
            ['YearLow', 1955],
            ['YearHigh', 1965],
            ['Remarks', 'Some remarks'],
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $site = new SiteSurveyEntity();
        $site->{"set$prop"}($value);
        $this->assertEquals($value, $site->{"get$prop"}());
    }
}
