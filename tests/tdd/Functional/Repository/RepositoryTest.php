<?php

namespace App\Tests\Functional\Repository;

use App\Entity\ContributeEntity;
use App\Entity\SiteEntity;
use App\Entity\Tmp\DraftEntity;
use App\Entity\Tmp\DraftErrorEntity;
use App\Entity\Voc\ChronologyEntity;
use App\Repository\ContributeRepository;
use App\Repository\SiteRepository;
use App\Repository\Tmp\DraftErrorRepository;
use App\Repository\Tmp\DraftRepository;
use App\Repository\Voc\ChronologyRepository;
use App\Tests\Functional\AbstractPgTestIsolation;

class RepositoryTest extends AbstractPgTestIsolation
{
    public function dataProvider()
    {
        return [
            [SiteEntity::class, SiteRepository::class],
            [ContributeEntity::class, ContributeRepository::class],
            [DraftEntity::class, DraftRepository::class],
            [DraftErrorEntity::class, DraftErrorRepository::class],
            [ChronologyEntity::class, ChronologyRepository::class],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string $entityClass
     * @param string $repositoryClass
     */
    public function testEntityRepositories(string $entityClass, string $repositoryClass)
    {
        $repo = $this->getEntityManager()->getRepository($entityClass);
        $this->assertInstanceOf($repositoryClass, $repo);
    }
}
