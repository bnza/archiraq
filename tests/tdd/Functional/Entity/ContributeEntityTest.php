<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 28/01/19
 * Time: 19.14
 */

namespace App\Tests\Functional\Entity;


use App\Tests\Functional\AbstractPgTestIsolation;
use App\Entity\ContributeEntity;

class ContributeEntityTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass()
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
    }

    public function assertPreConditions()
    {
        $em = $this->getEntityManager();
        $count = $em->getRepository(ContributeEntity::class)->count([]);
        $this->assertEquals(0, $count);
    }

    public function testPersistEntityDoesWork()
    {
        $entity = new ContributeEntity();
        $entity->setId(444);
        $entity->setEmail('mail@example.com');
        $entity->setContributor('A contributor');
        $entity->setInstitution('An institution');
        $entity->setDescription('A short description');
        $entity->setSha1(sha1('A'));
        $entity->setStatus(1);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        $this->assertEquals(1, $entity->getId());
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass()
    {
        self::rollbackDatabaseSchema();
    }
}
