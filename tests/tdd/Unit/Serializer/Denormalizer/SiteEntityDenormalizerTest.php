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
                  'modernName' => 'Tell Harba',
                  'compiler' => 'A. Name',
                  'compilationDate' => '2018-11-28',
                  'ancientName' => 'Ancient Name',
                  'ancientNameUncertain' => true,
                  'sbahNo' => null,
                  'cadastre' => null,
                  'remarks' => null,
                  'credits' => null
              ],
              [
                  'id' => 1,
                  'entryId' => 'AKK.001',
                  'modernName' => 'Tell Harba',
                  'compiler' => 'A. Name',
                  'compilationDate' => '',
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
     * @dataProvider siteEntityDataProvider
     * @param array $site
     * @param array $expected
     */
    public function testMethodDenormalizeWillReturnExpectedValue(array $site, array $expected)
    {
        $contribute = [
            'id' => (int) mt_rand(0, 100),
            'email' => 'mail@example.com',
            'sha1' => sha1(microtime())
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
