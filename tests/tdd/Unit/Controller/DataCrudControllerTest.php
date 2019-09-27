<?php


namespace App\Tests\Unit\Controller;

use App\Controller\DataCrudController;
use App\Repository\Geom\DistrictBoundaryRepository;
use App\Repository\Voc\ChronologyRepository;
use App\Repository\Voc\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;


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

    /**
     * @
     */
    public function testGetSurveyCodesStartingWithWillReturnsExpectedValues()
    {
        /** @var  SurveyRepository|MockObject $repo */
        $repo = $this->getMockBuilder(SurveyRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['filterByCodeStartWith'])
            ->getMock();
        $repo->expects($this->once())->method('filterByCodeStartWith')->willReturn([
            ['id' => 2, 'code' => 'ADAMS1972', 'name' => null, 'remarks' => null],
            ['id' => 3, 'code' => 'ADDER1973', 'name' => null, 'remarks' => null],
            ['id' => 4, 'code' => 'ADONIS1985', 'name' => null, 'remarks' => null],
        ]);
        $request = $this->createMock(Request::class);
        $request->query = new ParameterBag(['code-only' => '1']);
        $this->em->method('getRepository')->willReturn($repo);
        $response = $this->controller->getSurveyCodesStartingWith($request, 'AD');
        $this->assertJsonStringEqualsJsonString(
            '["ADAMS1972","ADDER1973","ADONIS1985"]',
            $response->getContent()
        );
    }
}
