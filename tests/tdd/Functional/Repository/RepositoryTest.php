<?php
namespace App\Tests\Functional\Repository;

use App\Entity\ContributeEntity;
use App\Entity\SiteEntity;
use App\Entity\TmpDraftEntity;
use App\Repository\ContributeRepository;
use App\Repository\SiteRepository;
use App\Repository\TmpDraftRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class RepositoryTest extends AbstractPgTestIsolation
{
    public function dataProvider()
    {
        return [
          [SiteEntity::class, SiteRepository::class],
          [ContributeEntity::class, ContributeRepository::class],
          [TmpDraftEntity::class, TmpDraftRepository::class]
        ];
    }
    /**
     * @dataProvider dataProvider
     * @param string $entityClass
     * @param string $repositoryClass
     */
    public function testEntityRepositories(string $entityClass, string $repositoryClass)
    {
        $repo = $this->getEntityManager()->getRepository($entityClass);
        $this->assertInstanceOf($repositoryClass, $repo);
    }
}
