<?php


namespace App\Tests\Unit\Serializer\Denormalizer;
use App\Entity\SiteSurveyEntity;
use App\Entity\SiteEntity;
use App\Entity\Voc\SurveyEntity;
use App\Serializer\Denormalizer\HttpDataSiteSurveyEntityDenormalizer;

class HttpDataSiteSurveyEntityDenormalizerTest extends \PHPUnit\Framework\TestCase
{
    public function testValidDataWithoutSite()
    {
        $json = <<<'EOD'
    {
      "id": 118,
      "ref": "015",
      "year_low": 1956,
      "year_high": 1957,
      "remarks": null,
      "survey": {
        "id": 4,
        "code": "ADAMS1972",
        "name": null,
        "remarks": null
      }
    }
EOD;
        $data = json_decode($json, true);
        $denormalizer = new HttpDataSiteSurveyEntityDenormalizer();
        $entity = $denormalizer->denormalize($data,SiteSurveyEntity::class);
        $this->assertInstanceOf(SiteSurveyEntity::class, $entity);
        $this->assertEquals(118, $entity->getId());
        $this->assertInstanceOf(SurveyEntity::class, $entity->getSurvey());
        $this->assertEquals(4, $entity->getSurvey()->getId());
    }

    public function testValidDataWithSite()
    {
        $json = <<<'EOD'
    {
      "id": 118,
      "ref": "015",
      "year_low": 1956,
      "year_high": 1957,
      "remarks": null,
      "survey": {
        "id": 4,
        "code": "ADAMS1972",
        "name": null,
        "remarks": null
      }
    }
EOD;
        $data = json_decode($json, true);
        $denormalizer = new HttpDataSiteSurveyEntityDenormalizer();
        $entity = $denormalizer->denormalize($data,SiteSurveyEntity::class, null, ['site'=> new SiteEntity()]);
        $this->assertInstanceOf(SiteEntity::class, $entity->getSite());
    }

}
