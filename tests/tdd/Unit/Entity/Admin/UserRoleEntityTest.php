<?php


namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\RoleEntity;
use App\Entity\Admin\UserRolesEntity;
use App\Entity\Admin\UserEntity;

class UserRoleEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
{
    return [
        ['User', new UserEntity()],
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
    $site = new UserRolesEntity();
    $site->{"set$prop"}($value);
    $this->assertEquals($value, $site->{"get$prop"}());
}

}
