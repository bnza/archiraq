<?php


namespace App\Tests\Unit\Security\Core\Encoder;

use App\Security\Core\Encoder\GeoServerDigest1Encoder;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Core\User\UserInterface;


class GeoServerDigest1EncoderTest extends \PHPUnit\Framework\TestCase
{
    public function digestDataProvider()
    {
        return [
            ['digest1:YgaweuS60t+mJNobGlf9hzUC6g7gGTtPEu0TlnUxFlv0fYtBuTsQDzZcBM4AfZHd', 'geoserver'],
            ['digest1:YgaweuS60t+mJNobGlf9hzUC6g7gGTtPEu0TlnUxFlv0fYtBuTsQDzZcBM4AfZHd', 'wrongPassword', false]
        ];
    }

    /**
     * @dataProvider digestDataProvider
     * @param string $digest
     * @param string $password
     * @param bool $isValid
     */
    public function testMethodIsPasswordValid(string $digest, string $password, bool $isValid = true)
    {
        /**
         * @var UserInterface | MockObject $user
         */
        $user = $this->getMockForAbstractClass(UserInterface::class);

        $user->method('getPassword')->willReturn($digest);

        $encoder = new GeoServerDigest1Encoder();

        $this->assertTrue($isValid === $encoder->isPasswordValid($user, $password));

    }

    public function testMethodEncodePassword()
    {
        $password = 'testPassword';

        /**
         * @var UserInterface | MockObject $user
         */
        $user = $this->getMockForAbstractClass(UserInterface::class);

        $encoder = new GeoServerDigest1Encoder();

        $digest = $encoder->encodePassword($user, $password);

        $user->method('getPassword')->willReturn($digest);

        $this->assertTrue($encoder->isPasswordValid($user, $password));
    }
}
