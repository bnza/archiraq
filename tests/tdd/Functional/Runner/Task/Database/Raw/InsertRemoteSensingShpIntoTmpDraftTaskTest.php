<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 31/01/19
 * Time: 20.50.
 */

namespace App\Tests\Functional\Runner\Task\Database\Raw;

use App\Entity\ContributeEntity;
use App\Runner\Task\Database\Raw\InsertRemoteSensingShpIntoTmpDraftTask;
use App\Tests\Functional\AbstractPgTestIsolation;
use App\Tests\Functional\Runner\Task\AbstractMockTrait;

class InsertRemoteSensingShpIntoTmpDraftTaskTest extends AbstractPgTestIsolation
{
    use AbstractMockTrait;

    /**
     * @var ContributeEntity
     */
    private $contribute;

    private $testedFields = [
        'id' => 'entry_id',
        'district' => 'district',
        'verified' => 'survey_verified_on_field',
        'compiler' => 'compiler',
        'mod_name' => 'modern_name',
        'anc_name' => 'ancient_name',
        'looting' => 'threats_looting',
        'bulldozer' => 'threats_bulldozer',
        'structures' => 'threats_modern_structures',
        'mod_channe' => 'threats_modern_canals',
        'nat_damage' => 'threats_natural_dunes',
        'remarks' => 'remarks',
    ];

    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
        $this->setUpBaseWorkDir();
        $this->setUpBaseOmDir();
    }

    public function tearDown()
    {
        $this->tearDownDir($this->getTestDir());
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }

    public function valueProvider()
    {
        return [
            [
                [
                    'id' => 'TEST.02',
                    'compiler' => 'Teste',
                    'district' => 'Nassriya',
                    'mod_name' => null,
                    'anc_name' => null,
                    'verified' => 'y',
                    'looting' => null,
                    'bulldozer' => 'n',
                    'structures' => null,
                    'mod_channe' => 'Y',
                    'nat_damage' => 't',
                    'remarks' => null,
                    'geom' => '0106000020E61000000100000001030000000100000005000000000000000000F03F000000000000F03F0000000000001440000000000000F03F00000000000014400000000000001440000000000000F03F0000000000001440000000000000F03F000000000000F03F'
                ]
            ]
        ];
    }

    /**
     * @dataProvider valueProvider
     *
     * @param array $values
     * @throws \Bnza\JobManagerBundle\Exception\JobManagerCancelledJobException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testTaskWillCompareTablesEntries(array $values)
    {
        $this->assertTableRowsNum(0, 'draft', 'tmp');
        $this->contribute = new ContributeEntity();
        $this->contribute->setEmail('test@email.com');
        $this->contribute->setContributor('A contributor');
        $this->setUpTask();
        $this->contribute->setSha1($this->getTask()->getJob()->getId());
        $this->getEntityManager()->persist($this->contribute);
        $this->getEntityManager()->flush();
        $this->fillShpTables($values);
        $this->getTask()->run();
        $this->assertTableRowsNum(1, 'draft', 'tmp');

        $sql = "SELECT * FROM \"tmp\".\"draft\"";
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        foreach ($this->testedFields as $key => $field) {
            $this->assertEquals($values[$key], $row[$field]);
        }
    }

    /**
     * @return MockObject|InsertRemoteSensingShpIntoTmpDraftTask
     */
    protected function getTask(): InsertRemoteSensingShpIntoTmpDraftTask
    {
        return $this->task;
    }

    protected function getTaskClassName(): string
    {
        return InsertRemoteSensingShpIntoTmpDraftTask::class;
    }

    protected function setUpAssets()
    {
    }

    protected function fillDraftTable()
    {
        $id = $this->getTask()->getJob()->getId();
        $this->setUpDraftTable();
        $sql = <<<EOT
INSERT INTO "draft$id" (entry_id) VALUES (:id); 
EOT;
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        foreach ($this->draftEntries as $id) {
            $stmt->execute(['id' => $id]);
        }
    }

    protected function fillShpTables($value)
    {
        $id = $this->getTask()->getJob()->getId();
        $this->setUpShpTable();
        $sql = <<<EOT
INSERT INTO "tmp"."shp2pgsql$id" 
    (
     id,
     compiler,
     district,
     mod_name,
     anc_name,
     verified,
     looting,
     bulldozer,
     structures,
     mod_channe,
     nat_damage,
     remarks,
     geom
     ) VALUES (
               :id,
               :compiler,
               :district,
               :mod_name,
               :anc_name,
               :verified,
               :looting,
               :bulldozer,
               :structures,
               :mod_channe,
               :nat_damage,
               :remarks,
               :geom
               ); 
EOT;
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute($value);
    }

    protected function callTaskSetters()
    {
        $this->getTask()->setEntityManager($this->getEntityManager());
        $this->getTask()->setContribute($this->contribute);
    }


    protected function setUpShpTable()
    {
        $id = $this->getTask()->getJob()->getId();
        $sql = <<<EOT
CREATE TABLE "tmp"."shp2pgsql$id" (gid serial,    
"id" varchar(7),    
"compiler" varchar(5),    
"district" varchar(8),    
"mod_name" varchar(14),    
"anc_name" varchar(1),    
"verified" varchar(1),    
"looting" varchar(1),    
"bulldozer" varchar(1),    
"structures" varchar(1),    
"mod_channe" varchar(1),    
"nat_damage" varchar(1),    
"remarks" varchar(53));
ALTER TABLE "tmp"."shp2pgsql$id" ADD PRIMARY KEY (gid);    
SELECT AddGeometryColumn('tmp','shp2pgsql$id','geom','4326','MULTIPOLYGON',2);
EOT;
        $this->getEntityManager()->getConnection()->exec($sql);
    }
}
