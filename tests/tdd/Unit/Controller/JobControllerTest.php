<?php


namespace App\Tests\Unit\Controller;

use App\Controller\JobController;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;

class JobControllerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $om;

    public function setUp()
    {
        $this->om = $this->getMockForAbstractClass(ObjectManagerInterface::class);
    }

    public function testMethodGenerateIdWillReturnAResponseWith40CharLengthId()
    {
        $controller = new JobController($this->om);
        $data = json_decode($controller->generateId()->getContent(), true);
        $this->assertEquals(40, strlen($data));
    }
}
