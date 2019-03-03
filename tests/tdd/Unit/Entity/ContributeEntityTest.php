<?php

namespace App\Tests\Unit\Entity;


use App\Entity\ContributeEntity;
use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\Tmp\DraftEntity;
use App\Entity\Voc\ChronologyEntity;

class ContributeEntityTest extends \PHPUnit\Framework\TestCase
{
    public function propValueProvider(): array
    {
        return [
            ['Id', 36],
            ['Email', 'email@example.com'],
            ['Contributor', 'A. Contributor'],
            ['Institution', 'An institution'],
            ['Description', 'A description'],
            ['Status', 3],
            ['Sha1', sha1('A')],
        ];
    }

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $contribute = new ContributeEntity();
        $contribute->{"set$prop"}($value);
        $this->assertEquals($value, $contribute->{"get$prop"}());
    }

    public function testMethodAddSiteDoesWork()
    {
        $site = new SiteEntity();
        $contribute = new ContributeEntity();
        $contribute->addSite($site);
        $this->assertCount(1, $contribute->getSites());
    }

    public function testMethodTmpDraftsDoesWork()
    {
        $draft = new DraftEntity();
        $contribute = new ContributeEntity();
        $contribute->addDraft($draft);
        $this->assertCount(1, $contribute->getDrafts());
    }
}
