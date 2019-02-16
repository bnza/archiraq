<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 09/02/19
 * Time: 14.02.
 */

namespace App\Tests\Unit\Serializer\Normalizer;

use App\Entity\ContributeEntity;
use App\Entity\TmpDraftEntity;
use App\Serializer\Normalizer\TmpDraftEntityNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class TmpDraftEntityNormalizerTest extends \PHPUnit\Framework\TestCase
{
    public function tmpEntitiesDataProvider()
    {
        return [
            [
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => null,
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                    'errors' => [],
                    'siteChronology' => null,
                    'district' => null,
                    'featuresEpigraphic' => null,
                    'featuresAncientStructures' => null,
                    'featuresPaleochannels' => null,
                    'featuresRemarks' => null,
                    'threatsNaturalDunes' => null,
                    'threatsLooting' => null,
                    'threatsCultivationTrenches' => null,
                    'threatsModernStructures' => null,
                    'threatsModernCanals' => null,
                    'geom' => null,
                ],
            ],
            [
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => 'Ancient Name',
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => 'Ancient Name',
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                    'errors' => [],
                    'siteChronology' => null,
                    'district' => null,
                    'featuresEpigraphic' => null,
                    'featuresAncientStructures' => null,
                    'featuresPaleochannels' => null,
                    'featuresRemarks' => null,
                    'threatsNaturalDunes' => null,
                    'threatsLooting' => null,
                    'threatsCultivationTrenches' => null,
                    'threatsModernStructures' => null,
                    'threatsModernCanals' => null,
                    'geom' => null,
                ],
            ],
            [
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => '?Ancient Name',
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'ancientName' => 'Ancient Name',
                    'ancientNameUncertain' => true,
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                    'errors' => [],
                    'siteChronology' => null,
                    'district' => null,
                    'featuresEpigraphic' => null,
                    'featuresAncientStructures' => null,
                    'featuresPaleochannels' => null,
                    'featuresRemarks' => null,
                    'threatsNaturalDunes' => null,
                    'threatsLooting' => null,
                    'threatsCultivationTrenches' => null,
                    'threatsModernStructures' => null,
                    'threatsModernCanals' => null,
                    'geom' => null,
                ],
            ],
        ];
    }

    /**
     * @dataProvider tmpEntitiesDataProvider
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
        $normalizer = new TmpDraftEntityNormalizer();
        $serializer = new Serializer([$normalizer, new GetSetMethodNormalizer()]);
        $contribute = $serializer->denormalize($contribute, ContributeEntity::class);
        $draft = $serializer->denormalize($draft, TmpDraftEntity::class);
        $draft->setContribute($contribute);
        $data = $normalizer->normalize($draft);
        unset($data['contribute']);
        $this->assertEquals($expected, $data);
    }
}
