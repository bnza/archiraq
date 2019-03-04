<?php

namespace App\Tests\Functional\Runner\Job;

use App\Entity\ContributeEntity;
use App\Tests\Functional\AbstractPgTestIsolation;
use Bnza\JobManagerBundle\ObjectManager\TmpFS\ObjectManager;
use App\Runner\Job\ValidateTmpDraftEntriesJob;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ValidateTmpDraftEntriesJobTest extends AbstractPgTestIsolation
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
     * @var ValidateTmpDraftEntriesJob
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

    public function assertPreConditions()
    {
        $this->assertTableRowsNum(0, 'draft_error', 'tmp');
    }

    /**
     * {@inheritdoc}
     */
    public function stepsDataAssertionsProvider(): array
    {
        return [
            [
                1,
                'assertThisTmpTablesContainsZeroEntry',
                [
                    'tdd/sql/test/validate_tmp_drafts_job/admbnd.sql',
                    'tdd/sql/chronology.sql',
                    'tdd/sql/test/validate_tmp_drafts_job/valid_fixtures.sql'
                ],
                true
            ],
            [
                1,
                'assertThisTmpTablesContainsTwoEntries',
                [
                    'tdd/sql/test/validate_tmp_drafts_job/admbnd.sql',
                    'tdd/sql/chronology.sql',
                    'tdd/sql/test/validate_tmp_drafts_job/invalid_fixtures.sql'
                ],
                false
            ],
        ];
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
    public function testJobSteps(int $limit, string $assertions, array $assets, bool $isValid)
    {
        $this->assets = $assets;
        $this->executeTestSteps($limit, $assertions);
        $repo = $this->getEntityManager()->getRepository(ContributeEntity::class);

        $contribute = $repo->find(100);
        // Assert status validate
        $this->assertTrue((bool) ($contribute->getStatus() & ContributeEntity::STATUS_VALIDATE));

        // Assert status valid
        $this->assertEquals($isValid, (bool) ($contribute->getStatus() & ContributeEntity::STATUS_VALID));

    }

    protected function getJobClassName(): string
    {
        return ValidateTmpDraftEntriesJob::class;
    }

    protected function setUpAssets()
    {
        foreach ($this->assets as $asset) {
            $this->executeSqlAssetFile($asset);
        }

    }

    protected function getJob(): ValidateTmpDraftEntriesJob
    {
        return $this->job;
    }

    protected function callJobSetters()
    {
        $this->job->setContribute(100);
        $this->job->setValidator($this->getValidator());
        $this->job->setEntityManager($this->getEntityManager());
    }

    protected function assertThisTmpTablesContainsZeroEntry()
    {
        $this->assertTableRowsNum(0, 'draft_error', 'tmp');
    }

    protected function assertThisTmpTablesContainsTwoEntries()
    {
        $this->assertTableRowsNum(2, 'draft_error', 'tmp');
    }
}
