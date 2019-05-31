<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\PgTestIsolationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DataCrudControllerTest extends WebTestCase
{
    use PgTestIsolationTrait;

    public static function setUpBeforeClass()
    {
        self::$client = self::createClient();
        self::$client->disableReboot();
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $this->executeSqlAssetFile('tdd/sql/test/data_crud_controller/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/data_crud_controller/fixtures.sql');
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function readControllerDataProvider()
    {
        return [
          ['/data/vw-site/1'],
          ['/data/vw-site']
        ];
    }

    /**
     * @dataProvider readControllerDataProvider
     */
    public function testMethodReadWillReturnJsonResponse(string $url)
    {
        self::$client->request('GET', $url);
        $this->assertTrue(self::$client->getResponse()->isSuccessful());
    }
}
