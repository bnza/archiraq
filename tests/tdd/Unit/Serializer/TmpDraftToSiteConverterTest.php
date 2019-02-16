<?php

namespace App\Tests\Unit\Serializer;

use App\Entity\ContributeEntity;
use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteEntity;
use App\Entity\TmpDraftEntity;
use App\Repository\Geom\DistrictBoundaryRepository;
use App\Serializer\TmpDraftToSiteConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class TmpDraftToSiteConverterTest extends \PHPUnit\Framework\TestCase
{
    public function entityDataProvider()
    {
        return [
            [
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => '?Ancient Name',
                    'district' => 'District',
                    'geom' => <<<EOF
                    { 
                        "type": "MultiPolygon",
                        "crs":{"type":"name","properties":{"name":"EPSG:4326"}},
                        "coordinates": [
                            [[[102.0, 2.0], [103.0, 2.0], [103.0, 3.0], [102.0, 3.0], [102.0, 2.0]]],
                            [[[100.0, 0.0], [101.0, 0.0], [101.0, 1.0], [100.0, 1.0], [100.0, 0.0]],
                            [[100.2, 0.2], [100.8, 0.2], [100.8, 0.8], [100.2, 0.8], [100.2, 0.2]]]
                        ]
                    }
EOF
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => new \DateTime(),
                    'ancientName' => 'Ancient Name',
                    'ancientNameUncertain' => true,
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                ],
            ],
        ];
    }

    /**
     * @dataProvider entityDataProvider
     *
     * @param array $draft
     * @param array $expected
     */
    public function testMethodNormalizeWillReturnExpectedValue(array $draft, array $expected)
    {
        $contribute = [
            'id' => (int) mt_rand(0, 100),
            'email' => 'mail@example.com',
            'sha1' => sha1(microtime()),
        ];
        $serializer = new Serializer([new GetSetMethodNormalizer()]);
        $draft = $serializer->denormalize($draft, TmpDraftEntity::class);
        $expected['compilationDate'] = \DateTime::createFromFormat('Y-m-d', '2018-11-28');
        $expected = $serializer->denormalize($expected, SiteEntity::class);

        $district = new DistrictBoundaryEntity();
        $repo = $this->createMock(DistrictBoundaryRepository::class);
        $repo->method('findByName')->willReturn($district);
        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturn($repo);

        $contribute = $serializer->denormalize($contribute, ContributeEntity::class);
        $draft->setContribute($contribute);
        $expected->setContribute($contribute);
        $converter = new TmpDraftToSiteConverter($em);

        $actual = $converter->convert($draft);
        $this->assertInstanceOf(DistrictBoundaryEntity::class, $actual->getDistrict());
        $this->assertInstanceOf(SiteBoundaryEntity::class, $actual->getGeom());
        $expected->setDistrict($district);
        $expected->setGeom($actual->getGeom());
        $this->assertEquals($expected, $actual);
    }
}
