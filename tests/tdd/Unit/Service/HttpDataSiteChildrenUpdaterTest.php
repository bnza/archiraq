<?php

namespace App\Tests\Unit\Service;

use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\Voc\ChronologyEntity;
use App\Service\HttpDataSiteChildrenUpdater;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Expr\Expression;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;

class HttpDataSiteChildrenUpdaterTest extends \PHPUnit\Framework\TestCase
{
    public function testRemoveDeletedChildrenMethodWithChronology()
    {
        $json = <<<'EOD'
          [
            {
              "id": 237,
              "chronology": {
                "id": 6,
                "code": "LC13",
                "name": "LATE CHALCOLITHIC 1-3/EARLY-MIDDLE URUK",
                "date_low": -4100,
                "date_high": -3500
              }
            },
            {
              "id": 170,
              "chronology": {
                "id": 36,
                "code": "ISLA",
                "name": "ISLAMIC",
                "date_low": 650,
                "date_high": 1500
              }
            },
            {
              "chronology": {
                "id": 36,
                "code": "ISLA",
                "name": "ISLAMIC",
                "date_low": 650,
                "date_high": 1500
              }
            }
          ]
EOD;
        $matchingChronologies = new ArrayCollection([
            (new SiteChronologyEntity())->setId(23),
            (new SiteChronologyEntity())->setId(46),
        ]);

        $chronologiesCollection = $this->getMockBuilder([Collection::class, Selectable::class])->getMock();
        $chronologiesCollection
            ->expects($this->once())
            ->method('matching')
            ->with($this->callback(function ($criteria) {
                /**
                 * @var Expression
                 */
                $expression = $criteria->getWhereExpression();

                return 'id' === $expression->getField() &&
                    'NIN' === $expression->getOperator() &&
                    [237, 170] == $expression->getValue()->getValue();
            }))
            ->willReturn($matchingChronologies);

        $site = $this->createMock(SiteEntity::class);
        $site->method('getChronologies')->willReturn($chronologiesCollection);

        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $em
            ->expects($this->once())
            ->method('find')
            ->with('App\Entity\SiteEntity', 111)
            ->willReturn($site);
        $em
            ->expects($this->exactly(2))
            ->method('remove')
            ->with($this->isInstanceOf(SiteChronologyEntity::class));

        $data = json_decode($json, true);

        $updater = new HttpDataSiteChildrenUpdater($em, 'chronology');
        $updater->removeDeletedChildren((new SiteEntity())->setId(111), $data);
    }

    public function testUpdateMethodWithChronology()
    {
        $json = <<<'EOD'
          [
            {
              "id": 237,
              "chronology": {
                "id": 6,
                "code": "LC13",
                "name": "LATE CHALCOLITHIC 1-3/EARLY-MIDDLE URUK",
                "date_low": -4100,
                "date_high": -3500
              }
            },
            {
              "chronology": {
                "id": 7,
                "code": "LC13",
                "name": "LATE CHALCOLITHIC 1-3/EARLY-MIDDLE URUK",
                "date_low": -4100,
                "date_high": -3500
              }
            }
          ]
EOD;
        $em = $this->getMockForAbstractClass(EntityManagerInterface::class);
        $em
            ->expects($this->once())
            ->method('merge')
            ->with($this->callback( function ($childEntity) {
                return  $childEntity->getSite() instanceof SiteEntity &&
                    $childEntity->getChronology()->getId() === 6;
            }));

        $em
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback( function ($childEntity) {
                return $childEntity->getChronology()->getId() === 7;
            }));

        $em
            ->method('find')
            ->withConsecutive(
                [ChronologyEntity::class,6],
                [ChronologyEntity::class,7]
                )
            ->willReturnOnConsecutiveCalls(
                (new ChronologyEntity())->setId(6),
                (new ChronologyEntity())->setId(7)
            );

        /**
         * @var MockObject|HttpDataSiteChildrenUpdater $updater
         */
        $updater = $this->getMockBuilder(HttpDataSiteChildrenUpdater::class)
            ->setConstructorArgs([$em, 'chronology'])
            ->setMethods(['removeDeletedChildren'])
            ->getMock();

        $data = json_decode($json, true);

        $updater->update(new SiteEntity(), $data);
    }
}
