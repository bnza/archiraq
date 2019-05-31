<?php

namespace App\Tests\Unit\Event;

use App\Event\XsrfListenerEventSubscriber;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class XsrfListenerEventSubscriberTest extends \PHPUnit\Framework\TestCase
{
    private $data = [
        'bingApiKey' => 'theBingApiKey',
        'geoServer' => [
            'baseUrl' => 'geoserverBaseUrl',
            'guestAuth' => 'aUser:thePass',
        ],
    ];

    private function setUpRequest(string $pathInfo = '/', string $method = 'GET', string $xsrfToken = 'wrongToken')
    {
        /**
         * @var Request|MockObject
         */
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['isMethod', 'getPathInfo', 'getMethod'])
            ->getMock();

        $request->method('isMethod')->willReturn($method);
        $request->method('getMethod')->willReturn($method);
        $request->method('getPathInfo')->willReturn($pathInfo);
        $request->headers = new HeaderBag(['x-xsrf-token' => $xsrfToken]);
        return $request;
    }

    private function setUpResponseEvent(Request $request, Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }
        /**
         * @var ResponseEvent|MockObject
         */
        $event = $this->getMockBuilder(ResponseEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRequest', 'getResponse'])
            ->getMock();

        $event->method('getRequest')->willReturn($request);
        $event->method('getResponse')->willReturn($response);
        return $event;
    }

    private function setUpRequestEvent(Request $request, Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }
        /**
         * @var ResponseEvent|MockObject
         */
        $event = $this->getMockBuilder(RequestEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRequest', 'getResponse', 'setResponse'])
            ->getMock();

        $event->method('getRequest')->willReturn($request);
        $event->method('getResponse')->willReturn($response);
        return $event;
    }

    private function setUpTokenManager(bool $isTokenValid = true)
    {
        $token = new CsrfToken('archiraq', 'tokenValue');
        $manager = $this->getMockForAbstractClass(CsrfTokenManagerInterface::class);
        $manager->method('getToken')->willReturn($token);
        $manager->method('refreshToken')->willReturn($token);
        $manager->method('isTokenValid')->willReturn($isTokenValid);
        return $manager;
    }

    public function testMethodOnKernelResponseWillNotSetCookiesIfPathInfoIsNotRoot()
    {
        $request = $this->setUpRequest('/some/path');
        $event = $this->setUpResponseEvent($request);
        $manager = $this->setUpTokenManager();

        $listener = new XsrfListenerEventSubscriber($manager);
        $listener->onKernelResponse($event);

        $cookies = $event->getResponse()->headers->getCookies();

        $this->assertCount(0, $cookies);
    }

    public function testMethodOnKernelResponseWillSetXsrfToken()
    {
        $request = $this->setUpRequest();
        $event = $this->setUpResponseEvent($request);
        $manager = $this->setUpTokenManager();

        $listener = new XsrfListenerEventSubscriber($manager);
        $listener->onKernelResponse($event);

        $cookies = $event->getResponse()->headers->getCookies();

        $this->assertCount(1, $cookies);
        $this->assertEquals($cookies[0]->getName(), 'xsrf-token');
    }

    public function testMethodOnKernelResponseWillRefreshToken()
    {
        $request = $this->setUpRequest();
        $event = $this->setUpResponseEvent($request);
        $manager = $this->setUpTokenManager();

        $manager->expects($this->once())->method('refreshToken');

        $listener = new XsrfListenerEventSubscriber($manager);
        $listener->onKernelResponse($event);
    }

    public function httpMethodsProvider()
    {
        return [
            ['PUT', 1],
            ['POST', 1],
            ['DELETE', 1],
            ['PATCH', 1],
            ['GET', 0],
            ['OPTIONS', 0]
        ];
    }

    /**
     * @dataProvider httpMethodsProvider
     * @param string $method
     * @param int $times
     */
    public function testMethodOnKernelRequestHttpMethod(string $method, int $times)
    {
        $request = $this->setUpRequest('/some/path', $method);
        $event = $this->setUpRequestEvent($request);
        $manager = $this->setUpTokenManager(false);

        $manager->expects($this->exactly($times))->method('getToken');

        $listener = new XsrfListenerEventSubscriber($manager);
        $listener->onKernelRequest($event);
    }

    public function testMethodOnKernelRequestSetInvalidXsrfTokenResponseWhenTokenIsInvalid()
    {
        $request = $this->setUpRequest('/some/path', 'POST');
        $event = $this->setUpRequestEvent($request);
        $manager = $this->setUpTokenManager(false);

        $listener = new XsrfListenerEventSubscriber($manager);
        $event->expects($this->once())->method('setResponse')->with($this->callback(function (Response $response) {
            return 412 === $response->getStatusCode();
        }));
        $listener->onKernelRequest($event);
    }

    public function testMethodOnKernelRequestSetInvalidXsrfTokenResponseWhenTokenDoesNotMatchTheRequestHeaderOne()
    {
        $request = $this->setUpRequest('/some/path', 'POST');
        $event = $this->setUpRequestEvent($request);
        $manager = $this->setUpTokenManager(true);

        $listener = new XsrfListenerEventSubscriber($manager);
        $event->expects($this->once())->method('setResponse')->with($this->callback(function (Response $response) {
            return 412 === $response->getStatusCode();
        }));
        $listener->onKernelRequest($event);
    }

    public function testMethodOnKernelRequestDoesNotSetInvalidXsrfTokenResponseWhenTokenIsValidAndMatching()
    {
        $request = $this->setUpRequest('/some/path', 'POST', 'tokenValue');
        $event = $this->setUpRequestEvent($request);
        $manager = $this->setUpTokenManager(true);

        $listener = new XsrfListenerEventSubscriber($manager);
        $event->expects($this->never())->method('setResponse');
        $listener->onKernelRequest($event);
    }

}
