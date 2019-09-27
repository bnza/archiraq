<?php


namespace App\Tests\Unit\Serializer\Denormalizer;
use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\Voc\ChronologyEntity;
use App\Serializer\Denormalizer\HttpDataSiteChronologyEntityDenormalizer;

class HttpDataSiteChronologyEntityDenormalizerTest extends \PHPUnit\Framework\TestCase
{
    public function testValidDataWithoutSite()
    {
        $json = <<<'EOD'
    {
      "id": 237,
      "chronology": {
        "id": 6,
        "code": "LC13",
        "name": "LATE CHALCOLITHIC 1-3/EARLY-MIDDLE URUK",
        "date_low": -4100,
        "date_high": -3500
      }
    }
EOD;
        $data = json_decode($json, true);
        $denormalizer = new HttpDataSiteChronologyEntityDenormalizer();
        $entity = $denormalizer->denormalize($data,SiteChronologyEntity::class);
        $this->assertInstanceOf(SiteChronologyEntity::class, $entity);
        $this->assertEquals(237, $entity->getId());
        $this->assertInstanceOf(ChronologyEntity::class, $entity->getChronology());
    }

    public function testValidDataWithSite()
    {
        $json = <<<'EOD'
    {
      "id": 237,
      "chronology": {
        "id": 6,
        "code": "LC13",
        "name": "LATE CHALCOLITHIC 1-3/EARLY-MIDDLE URUK",
        "date_low": -4100,
        "date_high": -3500
      }
    }
EOD;
        $data = json_decode($json, true);
        $denormalizer = new HttpDataSiteChronologyEntityDenormalizer();
        $entity = $denormalizer->denormalize($data,SiteChronologyEntity::class, null, ['site'=> new SiteEntity()]);
        $this->assertInstanceOf(SiteEntity::class, $entity->getSite());
    }

}
