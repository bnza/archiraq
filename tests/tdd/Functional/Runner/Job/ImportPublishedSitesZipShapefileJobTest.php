<?php

namespace App\Tests\Functional\Runner\Job;

use App\Entity\ContributeEntity;
use App\Tests\Functional\AbstractPgTestIsolation;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use App\Runner\Job\ImportPublishedSitesZipShapefileJob;
use Symfony\Component\EventDispatcher\EventDispatcher;


class ImportPublishedSitesZipShapefileJobTest extends AbstractPgTestIsolation
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
     * @var ImportPublishedSitesZipShapefileJob
     */
    protected $job;

    /**
     * @var string
     */
    private $zipPath;

    /**
     * @var ContributeEntity
     */
    private $contribute;

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

    public function assertPreConditions()
    {
        $this->assertDirIsEmpty($this->getBaseWorkDir());
        $this->assertDirIsEmpty($this->getBaseOmDir());
        $this->assertTableRowsNum(0, 'draft', 'tmp');
    }

    /**
     * {@inheritdoc}
     */
    public function stepsDataAssertionsProvider(): array
    {
        return [
            //[0, 'assertContributeEntityIsPersistedToDb'],
            [1, 'assertZipShapefileIsCopiedToWorkDir'],
            [2, 'assertZipShapefileIsExpandedInWorkDir'],
            [3, 'assertContributeEntityIsSetIntoJob'],
            [4, 'assertContributeEntityIsPersistedToDb'],
            [5, 'assertShp2PgsqlTableHasBeenDropped'],
            [6, 'assertDraftTableHasBeenCreated'],
            [8, 'assertDataAreBeenInsertInTmpDraftTable']
        ];
    }

    /**
     * Tests the job's steps up to the given limit and asserts the final status
     * @dataProvider stepsDataAssertionsProvider
     * @param int $limit
     * @param string $assertions
     */
    public function testJobSteps(int $limit, string $assertions)
    {
/*        $this->contribute = new ContributeEntity();
        $this->contribute->setSha1(sha1(microtime()));
        $this->contribute->setEmail('mail@example.com');*/
        $this->executeTestSteps($limit, $assertions);
    }

    protected function getJobClassName(): string
    {
        return ImportPublishedSitesZipShapefileJob::class;
    }

    protected function setUpAssets()
    {
        $this->zipPath = $this->copyAssetToTempDir('tdd/shp/zip/simple.shp.zip', 'site.zip');
        $this->assertFileExists($this->zipPath);
    }

    protected function getJob(): ImportPublishedSitesZipShapefileJob
    {
        return $this->job;
    }

    protected function callJobSetters()
    {
        if ($this->contribute) {
            $this->job->setContribute($this->contribute);
        }
        $this->job->setZipShapefilePath($this->zipPath);
        $this->job->setWorkDir($this->getBaseWorkDir());
        $this->job->setEntityManager($this->getEntityManager());
        //$this->job->setShapefileName('simple');
        $this->assertFileExists($this->getWorkDir($this->getJob()->getId()));
    }

    protected function assertContributeEntityIsPersistedToDb()
    {
        $this->assertTableRowsNum(1, 'contribute');
        $count = $this->getEntityManager()->getRepository(ContributeEntity::class)->count(['sha1'=>$this->getJob()->getId()]);
        $this->assertEquals(1, $count);
    }

    protected function assertContributeEntityIsSetIntoJob()
    {
        $this->assertInstanceOf(ContributeEntity::class, $this->getJob()->getContribute());
    }

    protected function assertZipShapefileIsCopiedToWorkDir()
    {
        $this->assertFileExists(
            $this->getWorkDir($this->getJob()->getId()) . DIRECTORY_SEPARATOR . 'site.zip',
            'Zip shapefile is copied to job work dir'
        );
    }

    protected function assertZipShapefileIsExpandedInWorkDir()
    {
        $this->assertFileExists(
            $this->getWorkDir($this->getJob()->getId()) . DIRECTORY_SEPARATOR . 'simple.shp',
            'Zip shapefile is expanded in job work dir'
        );
    }

    protected function assertShp2PgsqlTableHasBeenDropped()
    {
        $id = $this->getJob()->getId();
        $this->assertTableNotExists("shp2pgsql$id", "tmp");
    }

    protected function assertDraftTableHasBeenCreated()
    {
        $id = $this->getJob()->getId();
        $this->assertTemporaryTableExists("draft$id");
    }

    protected function assertDataAreBeenInsertInTmpDraftTable()
    {
        $this->assertTableRowsNum(1, 'draft', 'tmp');
    }

}
