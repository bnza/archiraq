<?php


namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\GroupEntity;
use App\Entity\Admin\GroupRolesEntity;
use App\Entity\Admin\RoleEntity;

class GroupRolesEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
{
    return [
        ['Group', new GroupEntity()],
        ['Role', new RoleEntity()],
    ];
}

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
{
    $site = new GroupRolesEntity();
    $site->{"set$prop"}($value);
    $this->assertEquals($value, $site->{"get$prop"}());
}

}
