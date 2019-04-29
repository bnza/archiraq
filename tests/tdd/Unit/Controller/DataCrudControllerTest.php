<?php


namespace App\Tests\Unit\Controller;

use App\Controller\DataCrudController;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;


class DataCrudControllerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var DataCrudController
     */
    private $controller;

    public function setUp()
    {
        /** @var EntityManagerInterface|MockObject $em */
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $this->controller = new DataCrudController($em);
    }

    public function entityNameDataProvider()
    {
        return [
            ['geom-nation', 'App\\Entity\\Geom\\NationBoundaryEntity'],
            ['vw-site',  'App\\Entity\\View\\SiteEntity']
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
}
