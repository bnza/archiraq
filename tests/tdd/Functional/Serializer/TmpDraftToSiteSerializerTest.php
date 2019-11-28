<?php

namespace App\Tests\Functional\Serializer;

use App\Entity\ContributeEntity;
use App\Entity\SiteEntity;
use App\Entity\Tmp\DraftEntity;
use App\Serializer\TmpDraftToSiteConverter;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\TestKernelUtilsTrait;

class TmpDraftToSiteSerializerTest extends AbstractPgTestIsolation
{
    use TestKernelUtilsTrait;

    /**
     * @var TmpDraftToSiteConverter
     */
    private $converter;

    public static function setUpBeforeClass()
    {
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

    public function testConverterWillSetChronology()
    {
        $this->executeSqlAssetFile('tdd/sql/test/tmp_draft_to_site_converter/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/chronology.sql');
        $draft = $this->getDraftEntity();
        $draft->setSiteChronology('ACH;AKK;UR3');
        $site = $this->getConverter()->convert($draft);
        $this->assertInstanceOf(SiteEntity::class, $site);
        $this->assertCount(3, $site->getChronologies());
        $this->getEntityManager()->persist($site);
        $this->getEntityManager()->flush();
    }

    public function testConverterWillSetSurvey()
    {
        $this->executeSqlAssetFile('tdd/sql/test/tmp_draft_to_site_converter/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/tmp_draft_to_site_converter/survey.sql');
        $draft = $this->getDraftEntity();
        $draft->setSurveyPrevRefs('Adams1972.002;Black1995.a');
        $draft->setSurveyVisitDate('1975-1977;1995');
        $site = $this->getConverter()->convert($draft);
        $this->assertInstanceOf(SiteEntity::class, $site);
        $this->assertCount(2, $site->getSurveys());
        $this->getEntityManager()->persist($site);
        $this->getEntityManager()->flush();
    }

    public function testConverterWillSetRemoteSensing()
    {
        $this->executeSqlAssetFile('tdd/sql/test/tmp_draft_to_site_converter/admbnd.sql');
        $this->executeSqlAssetFile('tdd/sql/test/tmp_draft_to_site_converter/survey.sql');
        $draft = $this->getDraftEntity();
        $draft->setSurveyPrevRefs('Adams1972.002;Black1995.a');
        $draft->setSurveyVisitDate('1975-1977;1995');
        $site = $this->getConverter()->convert($draft);
        $this->assertInstanceOf(SiteEntity::class, $site);
        $this->assertCount(2, $site->getSurveys());
        $this->getEntityManager()->persist($site);
        $this->getEntityManager()->flush();
    }

    private function getConverter(): TmpDraftToSiteConverter
    {
        if (!$this->converter) {
            $this->converter = new TmpDraftToSiteConverter($this->getEntityManager());
        }
        return $this->converter;
    }

    private function getDraftEntity(): DraftEntity
    {
        $contribute = new ContributeEntity();
        $contribute->setSha1(sha1('A'));
        $contribute->setId(1);
        $contribute->setEmail('example@mail.com');
        $this->getEntityManager()->persist($contribute);
        $draft = new DraftEntity();
        $draft->setCompilationDate('2018-11-22');
        $draft->setRemoteSensing('n');
        $draft->setDistrict('Hilla');
        $draft->setContribute($contribute);
        $draft->setId(1);
        $draft->setModernName('Modern Site Name');
        $draft->setCompiler('A. Compiler');
        $draft->setGeom('{ "type": "MultiPolygon", "crs":{"type":"name","properties":{"name":"EPSG:4326"}}, "coordinates": [ [ [ [ 44.1, 34.1 ], [ 45.8, 34.1 ], [ 45.8, 32.7 ], [ 44.1, 32.7 ], [ 44.1, 32.7 ], [ 44.1, 34.1 ] ] ] ] }');
        return $draft;
    }
}
