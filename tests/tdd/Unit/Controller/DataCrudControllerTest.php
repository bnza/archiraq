<?php


namespace App\Tests\Unit\Controller;

use App\Controller\DataCrudController;
use App\Repository\Geom\DistrictBoundaryRepository;
use App\Repository\Voc\ChronologyRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;


class DataCrudControllerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var DataCrudController
     */
    private $controller;

    /**
     * @var EntityManagerInterface|MockObject
     */
    private $em;

    public function setUp()
    {
        $this->em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $this->controller = new DataCrudController($this->em);
    }

    public function entityNameDataProvider()
    {
        return [
            ['geom-nation', 'App\\Entity\\Geom\\NationBoundaryEntity'],
            ['vw-site', 'App\\Entity\\View\\SiteEntity'],
            ['geom-district', 'App\\Entity\\Geom\\DistrictBoundaryEntity'],
            ['voc-chronology', 'App\\Entity\\Voc\\ChronologyEntity']
        ];
    }

    /**
     * @dataProvider entityNameDataProvider
     */
    public function testMethodGetEntityClassWillReturnExpectedValue(string $entityName, string $entityClass)
    {
        $this->assertEquals($entityClass, $this->controller->getEntityClass($entityName));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage "non-existent" is not mapped in this controller
     */
    public function testMethodGetEntityClassWillThrowExceptionWhenNoMatchingEntity()
    {
        $this->controller->getEntityClass('non-existent');
    }

    public function testGetDistrictNamesWillCallGetEntriesRepositoryRecord()
    {
        /** @var  DistrictBoundaryRepository|MockObject $repo */
        $repo = $this->getMockBuilder(DistrictBoundaryRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getEntries'])
            ->getMock();
        $repo->expects($this->once())->method('getEntries');
        $this->em->method('getRepository')->willReturn($repo);
        $this->controller->getDistrictNames();
    }

    public function testGetChronologyNamesWillCallGetEntriesRepositoryRecord()
    {
        /** @var  DistrictBoundaryRepository|MockObject $repo */
        $repo = $this->getMockBuilder(ChronologyRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getEntries'])
            ->getMock();
        $repo->expects($this->once())->method('getEntries');
        $this->em->method('getRepository')->willReturn($repo);
        $this->controller->getChronologyNames();
    }
}
