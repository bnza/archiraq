<?php

namespace App\Tests\Unit\Event;

use App\Event\EnvDataListenerEventSubscriber;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class EnvDataListenerEventSubscriberTest extends \PHPUnit\Framework\TestCase
{
    private $data = [
        'bingApiKey' => 'theBingApiKey',
        'geoServer' => [
            'baseUrl' => 'geoserverBaseUrl',
            'guestAuth' => 'aUser:thePass',
        ],
    ];

    private $event;
    private $listener;

    private function setUpRequest(string $pathInfo = '/', string $method = 'GET')
    {
        /**
         * @var Request|MockObject
         */
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['isMethod', 'getPathInfo'])
            ->getMock();

        $request->method('isMethod')->willReturn($method);
        $request->method('getPathInfo')->willReturn($pathInfo);
        return $request;
    }

    private function setUpEvent(Request $request, Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }
        /**
         * @var FilterResponseEvent|MockObject
         */
        $event = $this->getMockBuilder(ResponseEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRequest', 'getResponse'])
            ->getMock();

        $event->method('getRequest')->willReturn($request);
        $event->method('getResponse')->willReturn($response);
        return $event;
    }

    public function testMethodOnKernelResponseWillNotSetCookiesIfPathInfoIsNotRoot()
    {
        $request = $this->setUpRequest('/some/path');
        $event = $this->setUpEvent($request);

        $listener = new EnvDataListenerEventSubscriber($this->data);
        $listener->onKernelResponse($event);

        $cookies = $event->getResponse()->headers->getCookies();

        $this->assertCount(0, $cookies);
    }

    public function testMethodOnKernelResponseWillSetEnvDataCookie()
    {
        $request = $this->setUpRequest();
        $event = $this->setUpEvent($request);

        $listener = new EnvDataListenerEventSubscriber($this->data);
        $listener->onKernelResponse($event);

        $cookies = $event->getResponse()->headers->getCookies();

        $this->assertCount(1, $cookies);
        $this->assertEquals($cookies[0]->getName(), 'env-data');
    }

    public function testMethodOnKernelResponseWillSetEnvDataCookieValueAsExpected()
    {
        $request = $this->setUpRequest();
        $event = $this->setUpEvent($request);

        $listener = new EnvDataListenerEventSubscriber($this->data);
        $listener->onKernelResponse($event);

        $cookies = $event->getResponse()->headers->getCookies();

        $this->data['geoServer']['guestAuth'] = base64_encode($this->data['geoServer']['guestAuth']);

        $this->assertCount(1, $cookies);
        $this->assertJsonStringEqualsJsonString($cookies[0]->getValue(), json_encode($this->data));
    }
}
