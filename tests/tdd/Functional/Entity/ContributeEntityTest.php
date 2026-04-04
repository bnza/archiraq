<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 28/01/19
 * Time: 19.14.
 */

namespace App\Tests\Functional\Entity;

use App\Tests\Functional\AbstractPgTestIsolation;
use App\Entity\ContributeEntity;

class ContributeEntityTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass(): void
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
    }

    public function testPersistEntityDoesWork()
    {
        $count = $this->getEntityCount(ContributeEntity::class);
        $entity = new ContributeEntity();
        $entity->setId(444);
        $entity->setEmail('mail@example.com');
        $entity->setContributor('A contributor');
        $entity->setInstitution('An institution');
        $entity->setDescription('A short description');
        $entity->setSha1(sha1('A'));
        $entity->setStatus(1);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        $this->assertEquals($count + 1, $this->getEntityCount(ContributeEntity::class));
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }
}
