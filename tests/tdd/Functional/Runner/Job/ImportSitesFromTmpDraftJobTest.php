<?php

namespace App\Tests\Functional\Runner\Job;

use App\Runner\Job\ImportSitesFromTmpDraftJob;
use App\Tests\Functional\AbstractPgTestIsolation;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ImportSitesFromTmpDraftJobTest extends AbstractPgTestIsolation
{
    use AbstractJobTrait;

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var ImportSitesFromTmpDraftJobTest
     */
    protected $job;

    /**
     * @var array
     */
    private $assets = [];

    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->setUpBaseWorkDir();
        $this->setUpBaseOmDir();
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
        $this->tearDownDir($this->getTestDir());
    }

    protected function getJobClassName(): string
    {
        return ImportSitesFromTmpDraftJob::class;
    }

    protected function getJob(): ImportSitesFromTmpDraftJob
    {
        return $this->job;
    }

    /**
     * Data provider
     * [
     *  [0] => (int) The upper step limit,
     *  [1] => (string) The assertion method to call after running
     * ].
     *
     * @return array
     */
    public function stepsDataAssertionsProvider(): array
    {
        return [
            [
                2,
                'assertSiteTableTableContainsOneEntries',
                [
                    'tdd/sql/test/import_sites_from_tmp_draft_job/admbnd.sql',
                    'tdd/sql/chronology.sql',
                    'tdd/sql/test/import_sites_from_tmp_draft_job/valid_fixtures_validated.sql'
                ]
            ],
            [
                2,
                'assertSiteTableTableContainsOneEntries',
                [
                    'tdd/sql/test/import_sites_from_tmp_draft_job/admbnd.sql',
                    'tdd/sql/chronology.sql',
                    'tdd/sql/test/import_sites_from_tmp_draft_job/valid_fixtures_not_validated.sql'
                ]
            ]
        ];
    }

    protected function setUpAssets()
    {
        foreach ($this->assets as $asset) {
            $this->executeSqlAssetFile($asset);
        }
    }

    protected function callJobSetters()
    {
        $this->job->setContribute(101);
        $this->job->setValidator($this->getValidator());
        $this->job->setEntityManager($this->getEntityManager());
    }

    /**
     * Tests the job's steps up to the given limit and asserts the final status.
     *
     * @dataProvider stepsDataAssertionsProvider
     *
     * @param int    $limit
     * @param string $assertions
     * @param array $assets
     */
    public function testJobSteps(int $limit, string $assertions, array $assets)
    {
        $this->assets = $assets;
        $this->executeTestSteps($limit, $assertions);
    }

    protected function assertSiteTableTableContainsOneEntries()
    {
        $this->assertTableRowsNum(1, 'site');
    }
}
