<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\PgTestIsolationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class DataCrudControllerTest extends WebTestCase
{
    use PgTestIsolationTrait;

    /**
     * @var KernelBrowser
     */
    private static $localClient;

    public static function setUpBeforeClass(): void
    {
        self::$localClient = self::createClient();
        self::$localClient->disableReboot();
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }

    public function readControllerDataProvider()
    {
        return [
          ['/data/vw-site']
        ];
    }

    /**
     * @dataProvider readControllerDataProvider
     */
    public function testMethodReadWillReturnJsonResponse(string $url)
    {
        self::$localClient->request('GET', $url);
        $this->assertTrue(self::$localClient->getResponse()->isSuccessful());
        $content = json_decode(self::$localClient->getResponse()->getContent(), true);
        $siteId = $content['items'][0]['id'];
        $this->assertNotEmpty($siteId);
        self::$localClient->request('GET', $url.'/'.$siteId);
        $this->assertTrue(self::$localClient->getResponse()->isSuccessful());
    }
}
