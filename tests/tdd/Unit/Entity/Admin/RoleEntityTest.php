<?php

namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\GroupEntity;
use App\Entity\Admin\RoleEntity;
use App\Entity\Admin\UserEntity;

class RoleEntityTest extends \PHPUnit\Framework\TestCase
{
    public function propValueProvider(): array
    {
        return [
            ['Name', 'TheRoleName'],
            ['Parent', new RoleEntity()],
        ];
    }

    /**
     * @dataProvider propValueProvider
     *
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
    {
        $role = new RoleEntity();
        $role->{"set$prop"}($value);
        $this->assertEquals($value, $role->{"get$prop"}());
    }

    public function testAddGroupMethod()
    {
        $names = ['Group1', 'Group2'];
        $role = new RoleEntity();
        array_map(
            function ($name) use ($role) {
                $group = new GroupEntity();
                $group->setName($name);
                $role->addGroup($group);
            },
            $names
        );
        $this->assertCount(2, $role->getGroups());
    }

    public function testAddUserMethod()
    {
        $names = ['Group1', 'Group2'];
        $role = new RoleEntity();
        array_map(
            function ($name) use ($role) {
                $user = new UserEntity();
                $user->setName($name);
                $role->addUser($user);
            },
            $names
        );
        $this->assertCount(2, $role->getUsers());
    }
}
