<?php


namespace App\Security\Core\Encoder;

use InvalidArgumentException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The class is intended to check against the
 *
 * Class GeoServerDigest1Encoder
 * @package App\Security\Core\Encoder
 */
class GeoServerDigest1Encoder implements UserPasswordEncoderInterface
{
    const ALGORITHM = 'digest1';

    /**
     * Encodes the plain password as geoserver digest1 does
     *
     * @see https://docs.geoserver.org/stable/en/user/security/passwd.html#digest
     *
     * @param UserInterface $user The user
     * @param string $plainPassword The password to encode
     *
     * @return string The encoded password
     * @throws \Exception
     */
    public function encodePassword(UserInterface $user, $plainPassword): string
    {
        $salt64 = random_bytes(16);

        $digest = $this->generateDigest($salt64, $plainPassword);

        return "digest1:$digest";
    }

    /**
     * Check the provided $raw password against the stored geoserver digest1 password
     *
     * @param UserInterface $user The user
     * @param string        $raw  A raw password
     *
     * @return bool true if the password is valid, false otherwise
     */
    public function isPasswordValid(UserInterface $user, $raw): bool
    {
        /**
         * @var string $algo
         * @var string $digest
         */
        extract($this->splitDigest($user->getPassword()));

        if (!$algo) {
            throw new InvalidArgumentException('Invalid geoserver password string');
        } else if ($algo !== self::ALGORITHM) {
            throw new InvalidArgumentException("Only digest1 encryption's supported: $algo given");
        }

        $salt64 = $this->getBase64Salt($digest);

        $digest2 = $this->generateDigest($salt64, $raw);

        return $digest === $digest2;
    }

    /**
     * Split the raw geosever raw password into "algo" e "hash" chunks
     *
     * e.g. digest1:YgaweuS60t+mJNobGlf9hzUC6g7gGTtPEu0TlnUxFlv0fYtBuTsQDzZcBM4AfZHd
     * @param string $password
     * @return array
     */
    private function splitDigest(string $password): array
    {
        $pattern = '/^(?P<algo>\w+):(?P<digest>.+)$/';
        preg_match($pattern, $password, $matches);
        return $matches;
    }

    /**
     * Iterates sha256 with salt
     *
     * @param $message
     * @param $salt
     * @param int $iterations
     * @return string
     */
    private function iterateSha256($message, $salt, $iterations=100000): string
    {
        $hash = hash('sha256',$salt.$message, true);
        for ($i = 1; $i < $iterations; $i++) {
            $hash = hash('sha256', $hash, true);
        }
        return $hash;
    }

    /**
     * Goeserver digest1 hash has the salt value hardcoded into hash' first 16 byte. Get it!
     *
     * @param string $digest
     * @return string the base64 decoded salt string
     */
    private function getBase64Salt(string $digest): string
    {
        $digest64 = base64_decode($digest);
        //$hash64 = substr($digest64, 16);
        return substr($digest64, 0, 16);
    }

    /**
     * @param string $salt64 base64 decoded salt string
     * @param string $raw
     * @return string the base63 encoded digest
     */
    private function generateDigest(string $salt64, string $raw): string
    {
        $hash64 = $this->iterateSha256($raw, $salt64);
        return base64_encode($salt64.$hash64);
    }
}
