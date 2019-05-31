<?php


namespace App\Tests\Functional\Event;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class XsrfListenerEventSubscriberTest extends WebTestCase
{

    public static function setUpBeforeClass()
    {
        self::$client = self::createClient();
    }

    public function refreshingTokenUrlDataProvider()
    {
        return [
          ['/']
        ];
    }

    /**
     * @dataProvider refreshingTokenUrlDataProvider
     * @param string $url
     */
    public function testRequestingUrlWillRefreshXsrfToken(string $url)
    {
        self::$client->request('GET', $url);
        $response = self::$client->getResponse();
        $cookies = $response->headers->getCookies(ResponseHeaderBag::COOKIES_ARRAY);
        $this->assertArrayHasKey( '', $cookies);
        $this->assertArrayHasKey( '/', $cookies['']);
        $this->assertArrayHasKey( 'xsrf-token', $cookies['']['/']);
    }
}
