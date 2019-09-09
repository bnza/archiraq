<?php

namespace App\Tests\Functional\Repository\Tmp;

use App\Entity\Voc\SurveyEntity;
use App\Repository\Voc\SurveyRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class SurveyRepositoryTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->executeSqlAssetFile('tdd/sql/test/repository/voc_survey.sql');
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function assertPreConditions()
    {
        $this->assertTableRowsNum(5, 'survey', 'voc');
    }

    public function patternDataProvider()
    {
        return [
            [
                'A',
                [
                    ['id' => 3, 'code' => 'AARON1972-1973', 'name' => null, 'remarks' => null],
                    ['id' => 1, 'code' => 'ADAMS1972', 'name' => null, 'remarks' => null],
                    ['id' => 2, 'code' => 'ADAMS1973', 'name' => null, 'remarks' => null],
                    ['id' => 5, 'code' => 'ADAMS,BAKER1985', 'name' => null, 'remarks' => null],
                ],
                'AD',
                [
                    ['id' => 2, 'code' => 'ADAMS1972', 'name' => null, 'remarks' => null],
                    ['id' => 3, 'code' => 'ADAMS1973', 'name' => null, 'remarks' => null],
                    ['id' => 4, 'code' => 'ADAMS,BAKER1985', 'name' => null, 'remarks' => null],
                ],
            ],
        ];
    }

    /**
     * @dataProvider patternDataProvider
     * @param string $pattern
     * @param array $expected
     */
    public function testFilterByCodeStartWithMethodWillReturnExpectedValue(string $pattern, array $expected)
    {
        /** @var SurveyRepository $repo */
        $repo = $this->getEntityManager()->getRepository(SurveyEntity::class);
        $this->assertEquals($repo->filterByCodeStartWith($pattern), $expected);
    }
}
