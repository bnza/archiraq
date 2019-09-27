<?php


namespace App\Tests\Unit\Service;

use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\SiteEntity;
use App\Entity\Voc\ChronologyEntity;
use App\Serializer\Denormalizer\HttpDataSiteEntityDenormalizer;
use App\Service\HttpDataSiteChildrenUpdater;
use App\Service\HttpDataSiteUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;


class HttpDataSiteUpdaterTest extends \PHPUnit\Framework\TestCase
{

    public function testUpdateMethodWillRemoveDeletedChildren()
    {
        $site = (new SiteEntity())->setId(1);

        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);

        $denormalizer = $this->getMockForAbstractClass(DenormalizerInterface::class);
        $denormalizer->expects($this->once())->method('denormalize')->willReturn($site);

        $em->method('merge')->willReturn(
            $site
        );

        $data = file_get_contents(__DIR__.'/../../../assets/tdd/json/site_updater/validSite.json');

        $updater = $this
            ->getMockBuilder(HttpDataSiteUpdater::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$em])
            ->setMethods(['getDenormalizer', 'getChildrenUpdater'])
            ->getMock();

        $updater->method('getDenormalizer')->willReturn($denormalizer);

        $updater
            ->expects($this->exactly(2))
            ->method('getChildrenUpdater')
            ->willReturn($this->createMock(HttpDataSiteChildrenUpdater::class));

        $updater->update($data);
    }
}
