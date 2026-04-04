<?php

namespace App\Tests\Functional\Repository\Tmp;

use App\Entity\Voc\SurveyEntity;
use App\Repository\Voc\SurveyRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class SurveyRepositoryTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass(): void
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        //$this->executeSqlAssetFile('tdd/sql/test/repository/voc_survey.sql');
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }

    public function patternDataProvider()
    {
        return [
            [
                'A',
                'AD',
            ],
        ];
    }

    /**
     * @dataProvider patternDataProvider
     * @param string $pattern
     */
    public function testFilterByCodeStartWithMethodWillReturnExpectedValue(string $pattern)
    {
        /** @var SurveyRepository $repo */
        $repo = $this->getEntityManager()->getRepository(SurveyEntity::class);
        foreach ($repo->filterByCodeStartWith($pattern) as $survey) {
            $this->assertStringStartsWith($pattern, $survey['code']);
        }
    }
}
