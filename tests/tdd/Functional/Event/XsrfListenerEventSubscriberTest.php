<?php


namespace App\Tests\Functional\Event;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class XsrfListenerEventSubscriberTest extends WebTestCase
{

    /**
     * @var KernelBrowser
     */
    private static $localClient;

    public static function setUpBeforeClass()
    {
        self::$localClient = self::createClient();
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
        self::$localClient->request('GET', $url);
        $response = self::$localClient->getResponse();
        $cookies = $response->headers->getCookies(ResponseHeaderBag::COOKIES_ARRAY);
        $this->assertArrayHasKey( '', $cookies);
        $this->assertArrayHasKey( '/', $cookies['']);
        $this->assertArrayHasKey( 'xsrf-token', $cookies['']['/']);
    }
}
