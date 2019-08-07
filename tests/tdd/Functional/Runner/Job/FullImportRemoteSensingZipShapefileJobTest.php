<?php

namespace App\Tests\Functional\Runner\Job;

use App\Runner\Job\FullImportRemoteSensingZipShapefileJob;
use App\Tests\Functional\AbstractPgTestIsolation;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FullImportRemoteSensingZipShapefileJobTest extends AbstractPgTestIsolation
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
    private $assets = [
        'tdd/sql/admbnd0.sql',
        'tdd/sql/admbnd1.sql',
        'tdd/sql/admbnd2.sql',
        'tdd/sql/chronology.sql',
    ];

    /**
     * @var string
     */
    private $zipPath;

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
        return FullImportRemoteSensingZipShapefileJob::class;
    }

    protected function getJob(): FullImportRemoteSensingZipShapefileJob
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
                10,
                'assertSiteTableTableContainsOneEntries'
            ],
        ];
    }

    protected function setUpAssets()
    {
        foreach ($this->assets as $asset) {
            $this->executeSqlAssetFile($asset);
        }
        $this->zipPath = $this->copyAssetToTempDir('tdd/shp/zip/remote_sensing_full_import_job/working.shp.zip', 'site.zip');
    }

    protected function callJobSetters()
    {
        $this->job->setSourceZipShapefilePath($this->zipPath);
        $this->job->setWorkDir($this->getBaseWorkDir());
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
     */
    public function testJobSteps(int $limit, string $assertions)
    {
        $this->executeTestSteps($limit, $assertions);
    }

    protected function assertSiteTableTableContainsOneEntries()
    {
        $this->assertTableRowsNum(1, 'site');
    }
}
