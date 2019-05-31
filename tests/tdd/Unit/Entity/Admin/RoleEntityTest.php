<?php

namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\RoleEntity;

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
}
