<?php

namespace App\Tests\Functional\Service\Import;

use App\Entity\ContributeEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\SiteSurveyEntity;
use App\Service\Import\GeoJsonlImporter;
use App\Tests\Functional\AbstractPgTestIsolation;

class GeoJsonlImporterTest extends AbstractPgTestIsolation
{
    /** @var GeoJsonlImporter */
    private $importer;

    public static function setUpBeforeClass(): void
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        // Reset sequence to avoid conflicts after rollback (sequences are not transactional in PostgreSQL)
        $this->getConnection()->exec("SELECT setval('seq___contribute__id', (SELECT MAX(id) FROM public.contribute))");
        $this->importer = self::$container->get(GeoJsonlImporter::class);
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }

    public function testImportSurvey()
    {
        $file = 'tests/fixtures/geojsonl/survey.jsonl';
        $metadata = [
            'email' => 'unique_importer_test1@example.com',
            'contributor' => 'Test Contributor',
            'institution' => 'Test Institution',
            'description' => 'Test Description',
        ];

        $result = $this->importer->import($file, 'SURVEY', $metadata);

        $this->assertTrue($result->success);
        $this->assertEquals(1, $result->count);

        $em = $this->getEntityManager();

        /** @var SiteEntity $site */
        $site = $em->getRepository(SiteEntity::class)->findOneBy(['entry_id' => 'QD001'], ['id' => 'DESC']);
        $this->assertNotNull($site);
        $this->assertEquals('Afaq', $site->getNearestCity());
        $this->assertEquals(48, $site->getDistrict()->getId());

        // Verify Contribute
        $contribute = $site->getContribute();
        $this->assertEquals('unique_importer_test1@example.com', $contribute->getEmail());
        $this->assertEquals('Test Contributor', $contribute->getContributor());

        // Verify Chronologies (PART;SAS;ISLA)
        $this->assertCount(3, $site->getChronologies());

        // Verify Surveys (SUMER 2017;ZA 2019)
        $this->assertCount(2, $site->getSurveys());

        // Verify Geometry
        $this->assertNotNull($site->getGeom());
        $this->assertInstanceOf(SiteBoundaryEntity::class, $site->getGeom());
    }

    public function testImportSurveyNotSampled()
    {
        $file = 'tests/fixtures/geojsonl/survey_not_sampled.jsonl';
        $metadata = [
            'email' => 'unique_importer_test2@example.com',
        ];

        $result = $this->importer->import($file, 'SURVEY_NOT_SAMPLED', $metadata);

        $this->assertTrue($result->success);
        $this->assertEquals(1, $result->count);

        $em = $this->getEntityManager();

        /** @var SiteEntity $site */
        $site = $em->getRepository(SiteEntity::class)->findOneBy(['entry_id' => 'AKK.1123']);
        $this->assertNotNull($site);
        $this->assertEquals('not_sampled', $site->getSurveyType());
        $this->assertEquals(49, $site->getDistrict()->getId());

        // Verify Chronologies (Should be empty for not_sampled if not specified)
        $this->assertCount(0, $site->getChronologies());

        // Verify Surveys (ADAMS 1972)
        $this->assertCount(1, $site->getSurveys());
    }

    public function testImportRemoteSensing()
    {
        $file = 'tests/fixtures/geojsonl/remote_sensing.jsonl';
        $metadata = [
            'email' => 'unique_importer_test3@example.com',
        ];

        $result = $this->importer->import($file, 'REMOTE_SENSING', $metadata);

        $this->assertTrue($result->success);
        $this->assertEquals(3, $result->count);

        $em = $this->getEntityManager();

        /** @var SiteEntity $site */
        $site = $em->getRepository(SiteEntity::class)->findOneBy(['entry_id' => 'TIG.082']);
        $this->assertNotNull($site);
        $this->assertEquals(true, $site->isRemoteSensing());
        $this->assertEquals(29, $site->getDistrict()->getId());

        // Verify Chronologies (Should be empty for not_sampled if not specified)
        $this->assertCount(0, $site->getChronologies());

        // Verify Surveys (ADAMS 1972)
        $this->assertCount(0, $site->getSurveys());
    }

    public function testDryRunDoesNotSaveToDatabase()
    {
        $file = 'tests/fixtures/geojsonl/survey.jsonl';
        $metadata = ['email' => 'dryrun@example.com'];

        $em = $this->getEntityManager();

        // Count existing QD001 sites before dry-run
        // entry_id is unique per contribute, so this should be > 0
        $countBefore = (int) $em->getConnection()->fetchColumn(
            "SELECT COUNT(*) FROM public.site WHERE entry_id = 'QD001'"
        );

        $result = $this->importer->import($file, 'SURVEY', $metadata, true);

        $this->assertTrue($result->success);
        $this->assertEquals(1, $result->count);

        $em->clear();

        // No new QD001 site should have been added
        $countAfter = (int) $em->getConnection()->fetchColumn(
            "SELECT COUNT(*) FROM public.site WHERE entry_id = 'QD001'"
        );
        $this->assertEquals($countBefore, $countAfter, 'Dry-run should not insert new sites');

        $contribute = $em->getRepository(ContributeEntity::class)->findOneBy(['email' => 'dryrun@example.com']);
        $this->assertNull($contribute);
    }
}
