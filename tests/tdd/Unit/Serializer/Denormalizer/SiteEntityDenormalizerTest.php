<?php

namespace App\Tests\Unit\Serializer\Denormalizer;

use App\Entity\ContributeEntity;
use App\Entity\SiteEntity;
use App\Serializer\Denormalizer\SiteEntityDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class SiteEntityDenormalizerTest extends \PHPUnit\Framework\TestCase
{
    public function siteEntityDataProvider()
    {
        return [
            [
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'remoteSensing' => 'n',
                    'survey' => 'n',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => 'Ancient Name',
                    'ancientNameUncertain' => true,
                    'featuresEpigraphic' => 'y',
                    'featuresAncientStructures' => 'true',
                    'featuresPaleochannels' => '1',
                    'featuresRemarks' => 'reamarks on feature',
                    'threatsNaturalDunes' => 'y',
                    'threatsLooting' => 'true',
                    'threatsCultivationTrenches' => '1',
                    'threatsModernStructures' => '1',
                    'threatsModernCanals' => 'false',
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'remoteSensing' => false,
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '',
                    'ancientName' => 'Ancient Name',
                    'ancientNameUncertain' => true,
                    'sbahNo' => null,
                    'cadastre' => null,
                    'featuresEpigraphic' => true,
                    'featuresAncientStructures' => true,
                    'featuresPaleochannels' => true,
                    'featuresRemarks' => 'reamarks on feature',
                    'threatsNaturalDunes' => true,
                    'threatsLooting' => true,
                    'threatsCultivationTrenches' => true,
                    'threatsModernStructures' => true,
                    'threatsModernCanals' => false,
                    'remarks' => null,
                    'credits' => null,
                ],
            ],
        ];
    }

    /**
     * @dataProvider siteEntityDataProvider
     *
     * @param array $site
     * @param array $expected
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testMethodDenormalizeWillReturnExpectedValue(array $site, array $expected)
    {
        $contribute = [
            'id' => (int) mt_rand(0, 100),
            'email' => 'mail@example.com',
            'sha1' => sha1(microtime()),
        ];
        $denormalizer = new SiteEntityDenormalizer();
        $serializer = new Serializer([$denormalizer, new GetSetMethodNormalizer()]);
        $contribute = $serializer->denormalize($contribute, ContributeEntity::class);
        $actual = $serializer->denormalize($site, SiteEntity::class);
        $actual->setContribute($contribute);

        $site = new SiteEntity();
        $expected['contribute'] = $contribute;
        $expected['compilationDate'] = \DateTime::createFromFormat('Y-m-d', '2018-11-28');
        foreach ($expected as $prop => $value) {
            $site->{'set'.ucfirst($prop)}($value);
        }
        $this->assertEquals($site, $actual);
    }
}
