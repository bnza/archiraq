<?php


namespace App\Tests\Functional\Security\Guard;

use App\Tests\Functional\PgTestIsolationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class GeoServerDigest1AuthenticatorTest extends WebTestCase
{
    use PgTestIsolationTrait;

    /**
     * @var string
     */
    private $xsrfToken;

    public static function setUpBeforeClass()
    {
        self::$client = self::createClient();
        self::$client->disableReboot();
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

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function testLogin()
    {
        $this->executeSqlAssetFile('tdd/sql/test/security_geoserver_digest1_authenticator/user.sql');
        $this->setXsrfToken();
        self::$client->request(
            'POST',
            '/login',
            [
                'username' => 'testUser',
                'password' => 'testPassword'
            ],
            [],
            [
                'HTTP_x-xsrf-token' => $this->xsrfToken
            ]
        );
        $response = self::$client->getResponse();
        $this->assertTrue($response->isSuccessful());
    }

    private function setXsrfToken()
    {
        self::$client->request('GET', '/');
        $cookies = self::$client->getResponse()->headers->getCookies(ResponseHeaderBag::COOKIES_ARRAY);
        $this->xsrfToken = $cookies['']['/']['xsrf-token']->getValue();
    }

}
