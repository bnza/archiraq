<?php

namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\GroupEntity;
use App\Entity\Admin\RoleEntity;
use App\Entity\Admin\UserEntity;

class GroupEntityTest extends \PHPUnit\Framework\TestCase
{
    public function propValueProvider(): array
    {
        return [
            ['Name', 'TheRoleName'],
            ['Enabled', false, 'is'],
        ];
    }

    /**
     * @dataProvider propValueProvider
     *
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value, $getterPrefix = 'get')
    {
        $role = new GroupEntity();
        $role->{"set$prop"}($value);
        $this->assertEquals($value, $role->{"$getterPrefix$prop"}());
    }

    public function testAddRoleMethod()
    {
        $names = ['Role1', 'Role2'];
        $group = new GroupEntity();
        array_map(
            function ($name) use ($group) {
                $role = new RoleEntity();
                $role->setName($name);
                $group->addRole($role);
            },
            $names
        );
        $this->assertCount(2, $group->getRoles());
    }
}
