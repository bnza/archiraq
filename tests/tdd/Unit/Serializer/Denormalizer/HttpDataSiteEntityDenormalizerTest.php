<?php

namespace App\Tests\Unit\Service;

use App\Entity\ContributeEntity;
use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\SiteEntity;
use App\Serializer\Denormalizer\HttpDataSiteEntityDenormalizer;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;

class HttpDataSiteEntityDenormalizerTest extends \PHPUnit\Framework\TestCase
{
    private function assertSiteEntityValues($value, string $key, SiteEntity $site)
    {
        if (!\in_array($key, ['surveys', 'chronologies', 'compilation_date', 'district', 'contribute']))
        {
            foreach (['get', 'has', 'is'] as $prefix) {
                $method = $prefix.Inflector::classify($key);
                if (\method_exists($site, $method)) {
                    $this->assertEquals($value, $site->$method());
                }
            }
        } elseif ($key === 'district') {
            $this->assertInstanceOf(DistrictBoundaryEntity::class, $site->getDistrict());
        } elseif ($key === 'contribute') {
            $this->assertInstanceOf(ContributeEntity::class, $site->getContribute());
        }
        elseif ($key === 'compilation_date') {
            $this->assertEquals('2018-11-29T00:00:00+00:00', $site->getCompilationDate()->format(DATE_ATOM));
        }
    }

    public function testValidSiteUpdaterNoChildren()
    {
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);

        $em
            ->expects($this->exactly(2))
            ->method('find')
            ->withConsecutive(
                [ContributeEntity::class, $this->isType('int')],
                [DistrictBoundaryEntity::class, $this->isType('int')]
            )
            ->willReturnOnConsecutiveCalls(
                new ContributeEntity(),
                new DistrictBoundaryEntity()
            );

        $denormalizer = new HttpDataSiteEntityDenormalizer($em);

        $data = json_decode(
            file_get_contents(__DIR__.'/../../../../assets/tdd/json/site_updater/validSite.json'),
            true
        );

        unset($data['geom']);

        $site = $denormalizer->denormalize($data, SiteEntity::class);

        \array_walk(
            $data,
            [$this, 'assertSiteEntityValues'],
            $site
        );
    }
}
