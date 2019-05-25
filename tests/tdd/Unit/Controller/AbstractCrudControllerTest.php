<?php

namespace App\Tests\Unit\Controller;

use App\Controller\AbstractCrudController;
use App\Repository\AbstractCrudRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AbstractCrudControllerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var AbstractCrudController|MockObject
     */
    private $controller;

    public function setUp()
    {
        /** @var EntityManagerInterface|MockObject $em */
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $this->controller = $this->getMockForAbstractClass(AbstractCrudController::class, [$em]);
    }

    public function testMethodGetSetStatusCode()
    {
        $this->assertEquals(200, $this->controller->getStatusCode());
        $this->controller->setStatusCode(400);
        $this->assertEquals(400, $this->controller->getStatusCode());
    }

    public function testMethodRespondWithErrors()
    {
        $response = $this->controller->respondWithErrors(['exceptions' => 'Some exceptions'], ['Content-type' => 'xml']);
        $this->assertEquals('{"errors":{"exceptions":"Some exceptions"}}', $response->getContent());
        $this->assertEquals('xml', $response->headers->get('content-type'));
    }

    public function testMethodReadWillReturnExpectedResponse()
    {
        $result = ['id' => 3, 'value' => 'some value'];
        $repo = $this->getMockForAbstractClass(
            AbstractCrudRepository::class,
            [],
            '',
            false,
            true,
            true,
            ['findAsArray']
        );
        $repo->method('findAsArray')->willReturn($result);
        $this->controller->getEntityManager()->method('getRepository')->willReturn($repo);
        $response = $this->controller->read('some-entity', 3);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('{"id":3,"value":"some value"}', $response->getContent());
    }

    public function failingReadRequestProvider(): array
    {
        return [
          [NonUniqueResultException::class, 400, '{"errors":"Non unique result"}'],
          [NoResultException::class, 401, '{"errors":"No item found with id 3"}'],
        ];
    }

    /**
     * @dataProvider failingReadRequestProvider
     *
     * @param string $expectedExceptionClass
     * @param int $expectedStatus
     * @param string $expectedContent
     */
    public function testMethodReadWillReturnExpectedResponseOnError(
        string $expectedExceptionClass,
        int $expectedStatus,
        string $expectedContent
    ) {
        $e = new $expectedExceptionClass();
        $repo = $this->getMockForAbstractClass(
            AbstractCrudRepository::class,
            [],
            '',
            false,
            true,
            true,
            ['findAsArray']
        );
        $repo->method('findAsArray')->willThrowException($e);
        $this->controller->getEntityManager()->method('getRepository')->willReturn($repo);
        $response = $this->controller->read('some-entity', 3);
        $this->assertEquals($expectedStatus, $response->getStatusCode());
        $this->assertEquals($expectedContent, $response->getContent());
    }

    public function testMethodListWillReturnExpectedResponseOnError() {
        /** @var AbstractCrudRepository|MockObject $repo */
        $repo = $this->getMockForAbstractClass(
            AbstractCrudRepository::class,
            [],
            '',
            false,
            true,
            true,
            ['findByAsArray']
        );
        $repo->method('findByAsArray')->willThrowException(new \LogicException('some weird error'));
        $this->controller->getEntityManager()->method('getRepository')->willReturn($repo);
        $request = $this->createMock(Request::class);
        $response = $this->controller->list($request, 'some-entity');
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('{"errors":"some weird error"}', $response->getContent());
    }
}
