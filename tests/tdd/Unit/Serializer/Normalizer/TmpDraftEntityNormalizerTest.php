<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 09/02/19
 * Time: 14.02.
 */

namespace App\Tests\Unit\Serializer\Normalizer;

use App\Entity\ContributeEntity;
use App\Entity\Tmp\DraftEntity;
use App\Serializer\Normalizer\TmpDraftEntityNormalizer;
use Doctrine\Common\Collections\ArrayCollection;
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
                    'remoteSensing' => 'y'
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'remoteSensing' => 'y',
                    'ancientName' => null,
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                    'errors' => new ArrayCollection(),
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
                    'threatsBulldozer' => null,
                    'surveyVisitDate' => null,
                    'surveyVerifiedOnField' => null,
                    'surveyType' => null,
                    'surveyPrevRefs' => null,
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
                    'remoteSensing' => 'n'
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'remoteSensing' => 'n',
                    'ancientName' => 'Ancient Name',
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                    'errors' => new ArrayCollection(),
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
                    'threatsBulldozer' => null,
                    'surveyVisitDate' => null,
                    'surveyVerifiedOnField' => null,
                    'surveyType' => null,
                    'surveyPrevRefs' => null,
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
                    'remoteSensing' => null
                ],
                [
                    'id' => 1,
                    'entryId' => 'AKK.001',
                    'modernName' => 'Tell Harba',
                    'compiler' => 'A. Name',
                    'compilationDate' => '2018-11-28',
                    'remoteSensing' => null,
                    'ancientName' => 'Ancient Name',
                    'ancientNameUncertain' => true,
                    'sbahNo' => null,
                    'cadastre' => null,
                    'remarks' => null,
                    'credits' => null,
                    'errors' => new ArrayCollection(),
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
                    'threatsBulldozer' => null,
                    'threatsBulldozer' => null,
                    'surveyVisitDate' => null,
                    'surveyVerifiedOnField' => null,
                    'surveyType' => null,
                    'surveyPrevRefs' => null,
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
        $draft = $serializer->denormalize($draft, DraftEntity::class);
        $draft->setContribute($contribute);
        $data = $normalizer->normalize($draft);
        unset($data['contribute']);
        $this->assertEquals($expected, $data);
    }
}
