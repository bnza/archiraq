<?php


namespace App\Tests\Unit\Entity\Admin;

use App\Entity\Admin\UserEntity;

class UserEntityTest extends \PHPUnit\Framework\TestCase
{


    public function propValueProvider(): array
{
    return [
        ['Name', 'TheUsername'],
        ['Password', 'the password'],
    ];
}

    /**
     * @dataProvider propValueProvider
     * @param string $prop
     * @param $value
     */
    public function testSettersGettersDoesWork(string $prop, $value)
{
    $site = new UserEntity();
    $site->{"set$prop"}($value);
    $this->assertEquals($value, $site->{"get$prop"}());
}

}
