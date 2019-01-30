<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 31/01/19
 * Time: 14.10
 */

namespace App\Tests\Unit\Runner\Task\Database;

use App\Entity\ContributeEntity;
use App\Repository\ContributeRepository;
use App\Runner\Task\Database\PersistContributeTask;
use App\Tests\Unit\MockUtilsTrait;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;

class PersistContributeTaskTest extends \PHPUnit\Framework\TestCase
{
    use MockUtilsTrait;

    public function testSetContributeWithIntegerIdValueWillSetAValidContributeEntity()
    {
        $id = (int) mt_rand(0, 100);
        $entity = new ContributeEntity();
        $repository = $this->createMock(ContributeRepository::class, ['find']);
        $repository->method('find')->willReturn($entity);
        $repository->expects($this->once())->method('find')->with($this->equalTo($id));
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $em->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->getMockJob();
        $mockTask = $this->getMockTask(PersistContributeTask::class, ['getEntityManager']);
        $mockTask->expects($this->once())->method('getEntityManager')->willReturn($em);
        $mockTask->setContribute($id);
        $this->assertInstanceOf(ContributeEntity::class, $mockTask->getContribute());
    }

    public function testSetContributeWithStringSha1ValueWillSetAValidContributeEntity()
    {
        $sha1 = sha1(microtime());
        $entity = new ContributeEntity();
        $repository = $this->createMock(ContributeRepository::class, ['findBy']);
        $repository->method('findBy')->willReturn($entity);
        $repository->expects($this->once())->method('findBy')->with($this->contains($sha1));
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $em->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->getMockJob();
        $mockTask = $this->getMockTask(PersistContributeTask::class, ['getEntityManager']);
        $mockTask->expects($this->once())->method('getEntityManager')->willReturn($em);
        $mockTask->setContribute($sha1);
        $this->assertInstanceOf(ContributeEntity::class, $mockTask->getContribute());
    }

    public function testSetContributeWithContributeEntitySetAValidContributeEntity()
    {
        $entity = new ContributeEntity();
        $mockTask = $this->getMockTask(PersistContributeTask::class);
        $mockTask->setContribute($entity);
        $this->assertInstanceOf(ContributeEntity::class, $mockTask->getContribute());
    }

    public function testSetContributeWithValidArrayValueSetAValidContributeEntity()
    {
        $sha1 = sha1(microtime());
        $data = [
          'sha1' => $sha1,
          'email' => 'mail@example.com',
          'contributor' => 'J. Smith',
          'institution' => 'An Institution',
          'description' => 'A short description',
          'status' => 100
        ];
        $mockTask = $this->getMockTask(PersistContributeTask::class);
        $mockTask->setContribute($data);
        $entity = $mockTask->getContribute();
        $this->assertInstanceOf(ContributeEntity::class, $entity);

        foreach ($data as $key => $value) {
            $method = 'get'.Inflector::classify($key);
            $this->assertEquals($value, $entity->$method());
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid sha1 hash
     */
    public function testSetContributeWithStringValueWillThrowsException()
    {
        $mockTask = $this->getMockTask(PersistContributeTask::class);
        $mockTask->setContribute('Any non sha1 string');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument type: object [DateTime]
     */
    public function testSetContributeWithInvalidTypeWillThrowsException()
    {
        $mockTask = $this->getMockTask(PersistContributeTask::class);
        $mockTask->setContribute(new \DateTime());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No contribute found with id = 100
     */
    public function testSetContributeWithIntegerIdValueButNothingFoundWillThrowsException()
    {
        $repository = $this->createMock(ContributeRepository::class, ['find']);
        $repository->method('find')->willReturn(null);
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $em->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->getMockJob();
        $mockTask = $this->getMockTask(PersistContributeTask::class, ['getEntityManager']);
        $mockTask->method('getEntityManager')->willReturn($em);
        $mockTask->setContribute(100);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No contribute found with sha1 = 6dcd4ce23d88e2ee9568ba546c007c63d9131c1b
     */
    public function testSetContributeWithStringSha1ValueButNothingFoundWillThrowsException()
    {
        $repository = $this->createMock(ContributeRepository::class, ['findBy']);
        $repository->method('findBy')->willReturn([]);
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $em->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->getMockJob();
        $mockTask = $this->getMockTask(PersistContributeTask::class, ['getEntityManager']);
        $mockTask->method('getEntityManager')->willReturn($em);
        $mockTask->setContribute(sha1('A'));
    }

}
