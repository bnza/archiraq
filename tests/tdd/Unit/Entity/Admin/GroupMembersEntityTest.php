<?php


namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\GroupEntity;
use App\Entity\Admin\GroupMembersEntity;
use App\Entity\Admin\UserEntity;

class GroupMembersEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
{
    return [
        ['Group', new GroupEntity()],
        ['User', new UserEntity()],
    ];
}

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
{
    $site = new GroupMembersEntity();
    $site->{"set$prop"}($value);
    $this->assertEquals($value, $site->{"get$prop"}());
}

}
