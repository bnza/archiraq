<?php

namespace App\Tests\Unit\Serializer;


use App\Entity\ContributeEntity;
use App\Entity\SiteEntity;
use App\Entity\TmpDraftEntity;
use App\Serializer\TmpDraftToSiteConverter;
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
                    'ancientName' => '?Ancient Name'
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
                    'credits' => null
                ]
            ]
        ];
    }

    /**
     * @dataProvider entityDataProvider
     * @param array $draft
     * @param array $expected
     */
    public function testMethodNormalizeWillReturnExpectedValue(array $draft, array $expected)
    {
        $contribute = [
            'id' => (int) mt_rand(0, 100),
            'email' => 'mail@example.com',
            'sha1' => sha1(microtime())
        ];
        $serializer = new Serializer([new GetSetMethodNormalizer()]);
        $draft = $serializer->denormalize($draft, TmpDraftEntity::class);
        $expected['compilationDate'] = \DateTime::createFromFormat('Y-m-d', '2018-11-28');
        $expected = $serializer->denormalize($expected, SiteEntity::class);

        $contribute = $serializer->denormalize($contribute, ContributeEntity::class);
        $draft->setContribute($contribute);
        $expected->setContribute($contribute);
        $converter = new TmpDraftToSiteConverter();

        $actual = $converter->convert($draft);
        $this->assertEquals($expected, $actual);
    }
}
