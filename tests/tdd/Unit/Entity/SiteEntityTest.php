<?php

namespace App\Tests\Unit\Entity;


use App\Entity\ContributeEntity;
use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteEntity;
use App\Entity\SiteSurveyEntity;
use App\Entity\Voc\SurveyEntity;

class SiteEntityTest extends \PHPUnit\Framework\TestCase
{
    public function propValueProvider(): array
    {

        return [
            ['Id', 36],
            ['Contribute', new ContributeEntity()],
            ['EntryId', 'AKK.001'],
            ['SurveyVerifiedOnField', true, 'is'],
            ['RemoteSensing', true, 'is'],
            ['NearestCity', 'Nearest City'],
            ['ModernName', 'Modern Name'],
            ['AncientName', 'Ancient Name'],
            ['AncientNameUncertain', true, 'is'],
            ['SbahNo', 'SBAH no'],
            ['Cadastre', 'Cadastre'],
            ['FeaturesEpigraphic', true, 'has'],
            ['FeaturesAncientStructures', true, 'has'],
            ['FeaturesPaleochannels', true, 'has'],
            ['FeaturesRemarks', 'Some remarks on features'],
            ['ThreatsNaturalDunes', true, 'has'],
            ['ThreatsLooting', true, 'has'],
            ['ThreatsCultivationTrenches', true, 'has'],
            ['ThreatsModernStructures', true, 'has'],
            ['ThreatsModernCanals', true, 'has'],
            ['ThreatsBulldozer', true, 'has'],
            ['Compiler', 'A. Compiler'],
            ['CompilationDate', new \DateTime()],
            ['Remarks', 'Some remarks'],
            ['Credits', 'Some credits'],
            ['District', new DistrictBoundaryEntity()],
            ['Geom', new SiteBoundaryEntity()]
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     * @param string $getter
     */
    public function testSettersGettersDoesWork(string $prop, $value, string $getter = 'get')
    {
        $site = new SiteEntity();
        $site->{"set$prop"}($value);
        $this->assertEquals($value, $site->{"$getter$prop"}());
    }
}
